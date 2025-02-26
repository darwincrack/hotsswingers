<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\OssnRelationshipsModel;

use App\Modules\Api\Models\FavoriteModel;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;

use DB;

class EmailStreaming extends Command {

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'emailstreaming';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Enviar mail a los amigos y favoritos, cuando alguien inicia una transmisio en vivo';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {


    $datos = ChatThreadModel::where('sendMail', 1)
            ->join('users as u', 'chatthreads.ownerId', '=', 'u.id')->get();

    foreach($datos as $dato){


//enviar correo a favoritos
        $user_favorites = FavoriteModel::select("*")
        ->join('users as u', 'favorites.ownerId', '=', 'u.id')
        ->where('favoriteId', $dato->ownerId)
        ->get();

           foreach($user_favorites as $user_favorite){
             Mail::send('email.email_streaming', [
                    'data' => $user_favorite,
                    'user' =>$dato

                  ], function($message) use ($dato,$user_favorite){
                    $siteName = app('settings')->siteName;
                    $message
                      ->from(env('FROM_EMAIL') , app('settings')->siteName)
                      ->to($user_favorite->email)
                      ->subject($dato->username." está emitiendo en {$siteName}");
                  });

           }


        //enviar correo a amigos

        $user_friends = DB::table('ossn_relationships AS r')
        ->select('r.relation_from', 'u.username as username','u.email as email')
        ->join('ossn_relationships as r1', 'r1.relation_to', '=', 'r.relation_from')
        ->join('users AS u', 'r1.relation_to', '=', 'u.guid')
        ->join('users AS us', 'r1.relation_from', '=', 'us.guid')
        ->where('r1.relation_from', $dato->ownerId)
        ->where('r.relation_to', $dato->ownerId)
        ->where('r.type', 'friend:request')
        ->where('r1.type', 'friend:request')
        ->get();


           foreach($user_friends as $user_friend){
             Mail::send('email.email_streaming', [
                    'data' => $user_friend,
                    'user' =>$dato

                  ], function($message) use ($dato,$user_friend){
                    $siteName = app('settings')->siteName;
                    $message
                      ->from(env('FROM_EMAIL') , app('settings')->siteName)
                      ->to($user_friend->email)
                      ->subject($dato->username." está emitiendo en implik-2.com");
                  });

           }


  $affected = DB::table('chatthreads')
                ->where('sendMail', true)
                ->where('ownerId', $dato->ownerId)
                ->update(['sendMail' => false]);

    }



  }

}
