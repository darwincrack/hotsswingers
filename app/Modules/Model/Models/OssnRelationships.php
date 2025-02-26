<?php

 namespace App\Modules\Model\Models;

  use Illuminate\Database\Eloquent\Model;

  class OssnRelationships extends Model {

      protected $table = "ossn_relationships";
      protected $fillable = array('relation_id', 'relation_from', 'relation_to','type');
       const isBlock = 'userblock';

  }