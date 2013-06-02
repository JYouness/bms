<?php namespace Sorora\Bms\Models\Repositories\Category;

use Sorora\Empower\Models\Repositories\EloquentBaseRepository as EloquentBaseRepository;
use Sorora\Bms\Models\Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Sorora\Bms\Models\Category as Category;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepositoryInterface {

    public function posts()
    {
        return $this->model->posts();
    }

}