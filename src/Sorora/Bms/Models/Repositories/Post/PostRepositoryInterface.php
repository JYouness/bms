<?php namespace Sorora\Bms\Models\Repositories\Post;

interface PostRepositoryInterface {

    public function tags();
    public function categories();
    public function series();
    public function setTitleAttribute($value);
    public function highestSeriesOrder($id, $post_id = null);
    public function saveRelations($model, $items = null);

}