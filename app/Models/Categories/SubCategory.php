<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
    public function mainCategories(){
        return $this->belongsToMany('App\Models\Categories\MainCategory', 'sub_categories', 'id', 'main_category_id');
        // リレーションの定義
    }

    public function posts(){
        // リレーションの定義
    }
}
