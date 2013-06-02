<?php namespace Sorora\Bms\Models;

use Sorora\Empower\Models\SupportModel;

class Post extends SupportModel {
    protected $fillable = array('user_id', 'series_id', 'series_order', 'title', 'slug', 'content', 'published');

    public static $rules = array(
        'user_id' => 'required|exists:users,id',
        'title' => 'required|min:3',
        'slug' => 'required|min:3|alpha_dash|unique:posts,slug',
        'content' => 'required|min:10',
        'published' => 'required|in:0,1',
    );

    protected $table = 'posts';

    public function categories()
    {
        return $this->belongsToMany('Sorora\Bms\Models\Category', static::$dbprefix.'category_post', 'post_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Sorora\Bms\Models\Tag', static::$dbprefix.'post_tag', 'post_id', 'tag_id');
    }

    public function series()
    {
        return $this->belongsTo('Sorora\Bms\Models\Series', 'series_id');
    }
}
