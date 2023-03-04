<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\MainCategory;


class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
    public function mainCategory(){
        return $this->belongsTo('App\Models\Categories\MainCategory','post_sub_categories','sub_category_id','post_id');
        // リレーションの定義
    }

    public function posts(){
        return $this->belongsToMany('App\Models\Posts\Post');
        // リレーションの定義
    }
}
