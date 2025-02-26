<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model {
    protected $table = "categories";
    protected $guarded = [];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const NAME_EN = 'name_en';
    const NAME_FR = 'name_fr';

    public static function archives(){
        static $categories = null;
        if (!$categories) {
            $categories = static::all();
        }

        return $categories;
    }

    public function performer() {
        return $this->belongsTo(PerformerModel::class);
    }

    public function save(array $options = array()) {
        $this->slug = str_slug($this->name);
        $this->slug_en = str_slug($this->name_en);
        $this->slug_fr = str_slug($this->name_fr);
        parent::save($options);
    }
}
