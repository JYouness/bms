<?php namespace Sorora\Bms\Controllers;

use Sorora\Empower\Controllers\EmpowerController as EmpowerController;

use Sorora\Bms\Models\Repositories\Post\PostRepositoryInterface as Post;
use Sorora\Bms\Models\Repositories\Series\SeriesRepositoryInterface as Series;
use Sorora\Bms\Models\Repositories\Tag\TagRepositoryInterface as Tag;
use Sorora\Bms\Models\Repositories\Category\CategoryRepositoryInterface as Category;

use Carbon\Carbon;

class BlogController extends EmpowerController {

    protected $post;
    protected $series;
    protected $tag;
    protected $category;

    public function __construct(Post $post, Series $series, Tag $tag, Category $category)
    {
        parent::__construct();

        $this->post = $post;
        $this->series = $series;
        $this->tag = $tag;
        $this->category = $category;

        $this->data['baseurl'] = $this->baseurl .= 'blog';
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function post($slug)
    {
        $post = $this->post->getFromField('slug', $slug);

        // Only allow the author to preview a blog post when not published
        if($post->published !== 1 and \Auth::user()->id !== $post->user_id)
        {
            return \App::abort(404, 'Page not found');
        }

        $post->load('tags', 'categories');
        $this->data['post'] = $post;

        $series = $this->series->with(array('posts' => function($query) {
            $query->orderBy('series_order', 'asc');
        }))->find($post->series_id);

        $this->data['series'] = $series;

        $this->data['title'] = $post->title;
        $posted_on = new Carbon($post->created_at);
        $this->data['posted_on'] = $posted_on->diffForHumans();

        return \View::make('bms::blog.post', $this->data);
    }

}
