<?php namespace Sorora\Bms\Models\Repositories\Post;

use Sorora\Empower\Models\Repositories\EloquentBaseRepository as EloquentBaseRepository;
use Sorora\Bms\Models\Repositories\Post\PostRepositoryInterface as PostRepositoryInterface;
use Sorora\Bms\Models\Post as Post;

class EloquentPostRepository extends EloquentBaseRepository implements PostRepositoryInterface {

    public function tags()
    {
        return $this->model->tags();
    }

    public function categories()
    {
        return $this->model->categories();
    }

    public function series()
    {
        return $this->model->series();
    }

    public function setTitleAttribute($value)
    {
        return $this->model->setTitleAttribute($value);
    }

    public function highestSeriesOrder($id, $post_id = null)
    {
        return $this->model->highestSeriesOrder($id, $post_id);
    }

    public function saveRelations($model, $items = null)
    {
        return $this->model->saveRelations($model, $items);
    }

}