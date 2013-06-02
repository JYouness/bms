<?php namespace Sorora\Bms\Models\Repositories\Series;

use Sorora\Empower\Models\Repositories\EloquentBaseRepository as EloquentBaseRepository;
use Sorora\Bms\Models\Repositories\Series\SeriesRepositoryInterface as SeriesRepositoryInterface;
use Sorora\Bms\Models\Series as Series;

class EloquentSeriesRepository extends EloquentBaseRepository implements SeriesRepositoryInterface {

    public function posts()
    {
        return $this->model->posts();
    }

}