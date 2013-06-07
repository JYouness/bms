<?php namespace Sorora\Bms\Models;

use Sorora\Empower\Models\SupportModel;

use Carbon\Carbon;

class Post extends SupportModel {
    protected $fillable = array('user_id', 'series_id', 'series_order', 'title', 'slug', 'content', 'published');

    public static $rules = array(
        'user_id' => 'required|exists:users,id',
        'title' => 'required|min:3|unique:posts,title',
        'slug' => 'required_with:title|min:3|alpha_dash|unique:posts,slug',
        'content' => 'required|min:10',
        'published' => 'in:0,1',
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

    public function user()
    {
        return $this->belongsTo('Sorora\Aurp\Models\User', 'user_id');
    }

    public function getParsedAttribute()
    {
        $config = \Config::get('bms::formatter');
        if(empty($config))
        {
            return $this->content;
        }
        if(count($config) == 2)
        {
            return $config[0]::$config[1]($this->content);
        }
        
        return $config[0]($this->content);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }

    public function highestSeriesOrder($id, $post_id = null)
    {
        $post = Post::where('series_id', $id)->orderBy('series_order', 'desc')->first();

        if($post_id)
        {
            $current_post = Post::find($post_id);
            if($id == $current_post->series_id)
            {
                return $current_post->series_order;
            }
        }

        return ($post) ? $post->series_order + 1 : 1;
    }

    public function getDateDiffForHumans($field)
    {
        $carbon = new Carbon($this->$field);
        return $carbon->diffForHumans();
    }

    public function saveRelations($model, $items = null)
    {
        $model = 'Sorora\Bms\Models\\'.$model;

        $array = explode(',', ((is_array($items)) ? $items : \Input::get($items)));

        $not_new_items = Post::findExistingItems($model, Post::slugItems($array));

        $ids = array_merge(Post::currentIds($not_new_items), Post::saveNewItems($model, array_diff($array, $not_new_items)));

        return (!empty($ids)) ? $ids : array();
    }

    protected function slugItems($array)
    {
        $return = array();
        foreach($array AS $item)
        {
            $return[] = \Str::slug($item);
        }
        return $return;
    }

    protected function findExistingItems($model, $array)
    {
        return $model::whereIn('slug', $array)->lists('name', 'id');
    }

    protected function currentIds($array)
    {
        $ids = array();
        foreach($array AS $id => $value)
        {
            $ids[] = $id;
        }
        return $ids;
    }
    protected function saveNewItems($model, $items)
    {
        $ids = array();
        foreach($items AS $item)
        {
            $item = trim($item);
            $created = $model::create(array('name' => $item, 'slug' => \Str::slug($item)));
            if(is_null($created->errors))
            {
                $ids[] = $created->id; 
            }
        }
        return $ids;
    }
}
