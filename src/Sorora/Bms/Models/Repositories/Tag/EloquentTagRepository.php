<?php namespace Sorora\Bms\Models\Repositories\Tag;

use Sorora\Empower\Models\Repositories\EloquentBaseRepository as EloquentBaseRepository;
use Sorora\Bms\Models\Repositories\Tag\TagRepositoryInterface as TagRepositoryInterface;
use Sorora\Bms\Models\Tag as Tag;

class EloquentTagRepository extends EloquentBaseRepository implements TagRepositoryInterface {

    public function posts()
    {
        return $this->model->posts();
    }

}