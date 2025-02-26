<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Response;

class MultiretosModel extends Model {

  protected $table = "multiretos";

  protected $fillable = ['active', 'completado','ganancia','reto_actual'];
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';


    public static function get($uid) {
    	   $data = null;

        $data = MultiretosModel::select('*','multiretos.id as multiretos_id','reto_text as task')
  	    ->Join('users', 'multiretos.user_id','=', 'users.id')
  	    ->where('multiretos.active', '=', true)
  	    ->where('multiretos.user_id', '=', $uid)
  	    ->get();


      return $data;


}



  /*  public static function getFirst($uid) {
         $data = null;

        $data = MultiretosModel::select('*','multiretos.id as multiretos_id','reto_text as task')
        ->Join('users', 'multiretos.user_id','=', 'users.id')
        ->where('multiretos.active', '=', true)
        ->where('multiretos.completado', '=', 0)
        ->where('multiretos.user_id', '=', $uid)
        ->first();


      return $data;


}*/



    public static function getFirst($uid) {
         $data = null;

        $data = MultiretosModel::select('*','multiretos.id as multiretos_id','reto_text as task')
        ->Join('users', 'multiretos.user_id','=', 'users.id')
        ->where('multiretos.active', '=', true)
        ->where('multiretos.completado', '=', 0)
        ->where('multiretos.reto_actual', '=', 1)
        ->where('multiretos.user_id', '=', $uid)
        ->first();


      return $data;


}


    public static function getNext($uid) {
         $data = null;

        $data = MultiretosModel::select('*','multiretos.id as multiretos_id','reto_text as task')
        ->Join('users', 'multiretos.user_id','=', 'users.id')
        ->where('multiretos.active', '=', true)
        ->where('multiretos.completado', '=', 0)
        ->where('multiretos.user_id', '=', $uid)
        ->first();


      return $data;


}



    public static function getallretos($uid) {
         $data = null;

        $data = MultiretosModel::select('*','multiretos.id as multiretos_id','reto_text as task')
        ->Join('users', 'multiretos.user_id','=', 'users.id')
        ->where('multiretos.active', '=', true)
        ->where('multiretos.completado', '=', 0)
        ->where('multiretos.user_id', '=', $uid)
        ->get();


      return $data;


}



    public static function getMaxid($uid) {
         $data = null;

        $data = MultiretosModel::select('multiretos.id as multiretos_id')
        ->Join('users', 'multiretos.user_id','=', 'users.id')
        ->where('multiretos.user_id', '=', $uid)
        ->orderBy('multiretos.id', 'DESC')
        ->first();


      return $data;


}





    public static function AllGames($uid) {
  	$games = null;


  $games = GamesModel::select('*','games.createdAt as gamescreatedAt')
	    ->Join('juguetes', 'games.id','=', 'juguetes.games_id')
	    ->Join('users', 'games.user_id','=', 'users.id')
	    ->where('games.user_id', '=', $uid)
	    ->orderBy('games.createdAt', 'desc')
	    ->get();
 return Response::json($games->toArray());

   // return $games;


}


    public static function getLastGame($uid) {
    $games = null;


  $games = GamesModel::select('*')
      ->Join('juguetes', 'games.id','=', 'juguetes.games_id')
      ->Join('users', 'games.user_id','=', 'users.id')
      ->where('games.user_id', '=', $uid)
      ->orderBy('games.createdAt', 'desc')
      ->first();


    return $games;


}

}