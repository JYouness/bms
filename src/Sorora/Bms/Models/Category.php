<?php namespace Sorora\Bms\Models;

use Sorora\Empower\Models\SupportModel;

class Category extends SupportModel {
    protected $fillable = array('name', 'slug');

    public static $rules = array(
        'name' => 'required|min:3|unique:categories,name',
        'slug' => 'required|min:3|alpha_dash|unique:categories,slug'
    );

    protected $table = 'categories';

    public function posts()
    {
        return $this->belongsToMany('Sorora\Bms\Models\Post', static::$dbprefix.'category_post', 'category_id', 'post_id');
    }
}
