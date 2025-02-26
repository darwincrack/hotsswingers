<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class PremiosGanadoresModel extends Model {

  protected $table = "premiosganadores";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';


    public static function findByUserId($user_id) {
    $data = PremiosGanadoresModel::select('user_id')
    ->where('user_id', '=', $user_id)
    ->whereDate('createdAt', '=', date('Y-m-d'))
    ->first();
    return $data;
  }


}
