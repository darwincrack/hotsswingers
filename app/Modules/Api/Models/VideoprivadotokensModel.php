<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Response;
use db;

class VideoprivadotokensModel extends Model {

  protected $table = "videoprivadotokens";

  protected $fillable = ['tokens', 'active','modelId','ownerId'];
  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';


    public static function get($modelid, $ownerId ) {
    	   $data = null;

        $data = VideoprivadotokensModel::select('users.username',DB::raw("ifnull(SUM(videoprivadotokens.tokens), 0) as tokensprivado"))
  	    ->Join('users', 'videoprivadotokens.ownerId','=', 'users.id')
  	    ->where('videoprivadotokens.active', '=', true)
  	    ->where('videoprivadotokens.modelId', '=', $modelid)
        ->where('videoprivadotokens.ownerId', '=', $ownerId)
  	    ->first();


      return $data;


}



    public static function Participantes($modelid ) {
         $data = null;

        $data = VideoprivadotokensModel::select('users.username',DB::raw("ifnull(SUM(videoprivadotokens.tokens), 0) as tokensprivado"))
        ->Join('users', 'videoprivadotokens.ownerId','=', 'users.id')
        ->where('videoprivadotokens.active', '=', true)
        ->where('videoprivadotokens.modelId', '=', $modelid)
        ->groupBy('ownerId')
        ->get();


      return $data;


}

}