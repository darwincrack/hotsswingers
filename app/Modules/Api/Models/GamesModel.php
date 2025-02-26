<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Response;

class GamesModel extends Model {

  protected $table = "games";
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';


    public static function Games($uid) {
  	$games = null;


  $games = GamesModel::select('*')
	    ->Join('juguetes', 'games.id','=', 'juguetes.games_id')
	    ->Join('users', 'games.user_id','=', 'users.id')
	    ->where('games.active', '=', true)
	    ->where('games.user_id', '=', $uid)
	    ->first();


    return $games;


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