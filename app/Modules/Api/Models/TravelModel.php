<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class TravelModel extends Model {

  protected $table = "travel";

const CREATED_AT = 'createdAt';
const UPDATED_AT = 'updatedAt';


  public function performer(){
      return $this->belongsTo(PerformerModel::class);
  }
  
  
}