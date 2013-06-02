<?php namespace Sorora\Bms\Models;

use Sorora\Empower\Models\SupportModel;

class Series extends SupportModel {
    protected $fillable = array('title');

    public static $rules = array(
        'title' => 'required|min:3|unique:series,title'
    );

    protected $table = 'series';

    public function posts()
    {
        return $this->hasMany('Sorora\Bms\Models\Post', 'series_id');
    }
}
