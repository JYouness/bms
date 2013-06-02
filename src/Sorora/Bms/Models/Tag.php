<?php namespace Sorora\Bms\Models;

use Sorora\Empower\Models\SupportModel;

class Tag extends SupportModel {
    protected $fillable = array('name', 'slug');

    public static $rules = array(
        'name' => 'required|min:3|unique:tags,name',
        'slug' => 'required|min:3|alpha_dash|unique:tags,slug'
    );

    protected $table = 'tags';

    public function posts()
    {
        return $this->belongsToMany('Sorora\Bms\Models\Post', static::$dbprefix.'post_tag', 'tag_id', 'post_id');
    }
}
