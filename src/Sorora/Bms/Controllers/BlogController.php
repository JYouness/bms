<?php namespace Sorora\Bms\Controllers;

use Sorora\Empower\Controllers\EmpowerController as EmpowerController;

use Sorora\Bms\Models\Repositories\Post\PostRepositoryInterface as Post;
use Sorora\Bms\Models\Repositories\Series\SeriesRepositoryInterface as Series;
use Sorora\Bms\Models\Repositories\Tag\TagRepositoryInterface as Tag;
use Sorora\Bms\Models\Repositories\Category\CategoryRepositoryInterface as Category;

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
     * Display a post retrieved from the slug
     *
     * @param  string  $slug
     * @return Response
     */
    public function post($slug)
    {
        $post = $this->post->with(array('categories' => function ($query) {
           $query->orderBy('name', 'asc'); 
        }, 'tags' => function ($query) {
           $query->orderBy('name', 'asc'); 
        }))->where('slug', $slug)->firstOrFail();

        // Only allow the author to preview a blog post when not published
        if($post->published !== 1 and \Auth::user()->id !== $post->user_id)
        {
            return \App::abort(404, 'Page not found');
        }

        $this->data['post'] = $post;

        $series = $this->series->with(array('posts' => function($query) {
            $query->orderBy('series_order', 'asc');
        }))->find($post->series_id);

        $this->data['series'] = $series;

        $this->data['title'] = $post->title;
        $this->data['posted_on'] = $post->getDateDiffForHumans('created_at');
        if($post->updated_at > $post->created_at)
        {
            $this->data['updated_on'] = $post->getDateDiffForHumans('updated_at'); 
        }

        return \View::make($this->viewFromConfig('bms', 'blog', 'post'), $this->data);
    }

    /**
     * Display a category listing posts from the slug.
     *
     * @param  string  $slug
     * @return Response
     */
    public function category($slug)
    {
        $category = $this->category->with(array('posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }))->where('slug', $slug)->firstOrFail();

        return $this->singleList($category, 'category');
    }

    /**
     * Display a tag listing posts from the slug.
     *
     * @param  string  $slug
     * @return Response
     */
    public function tag($slug)
    {
        $tag = $this->tag->with(array('posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }))->where('slug', $slug)->firstOrFail();

        return $this->singleList($tag, 'tag');
    }

    protected function singleList($item, $item_name, $title = null)
    {
        $this->data['title'] = ($title) ?: $item->name;
        $this->data['item'] = $item;
        $this->data['item_name'] = $item_name;
        return \View::make($this->viewFromConfig('bms', 'blog', 'list'), $this->data);
    }

}