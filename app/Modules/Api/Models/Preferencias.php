<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Preferencias extends Model {

protected $table = "Preferencias";

const Preferencias_id = 'Preferencias_id';
const descripcionES = 'descripcionES';
const descripcionEN = 'descripcionEN';
const descripcionFR = 'descripcionFR';

  public function performer(){
      return $this->belongsTo(PerformerModel::class);
  }
  
}
