<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Gustos extends Model {

  protected $table = "gustos";

const descripcionES = 'descripcion';
const descripcionEN = 'descripcion';
const descripcionFR = 'descripcion';
const CREATED_AT = 'createdAt';
const UPDATED_AT = 'updatedAt';


  public function performer(){
      return $this->belongsTo(PerformerModel::class);
  }
  
  
}
