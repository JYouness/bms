<?php namespace Sorora\Bms\Controllers;

use Sorora\Empower\Controllers\EmpowerController as EmpowerController;

use Sorora\Bms\Models\Repositories\Post\PostRepositoryInterface as Post;
use Sorora\Bms\Models\Repositories\Series\SeriesRepositoryInterface as Series;

class PostsController extends EmpowerController {

    protected $post;
    protected $series;

    public function __construct(Post $post, Series $series)
    {
        parent::__construct();

        $this->post = $post;
        $this->series = $series;

        $this->data['baseurl'] = $this->baseurl .= 'posts';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->data['title'] = 'Posts';

        $this->data['posts'] = $this->post->all();

        return \View::make('bms::posts.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['title'] = 'Create Post';

        \View::share('series', array(0 => 'None') + $this->series->orderBy('title', 'asc')->lists('title', 'id'));
        \View::share('post', (object) array('series_id' => null, 'published' => null));
        \View::share('current_tags', '');
        \View::share('current_categories', '');

        return \View::make('bms::posts.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->post = $this->post->create(
            \Input::all() + 
            array(
                'slug' => $this->post->slug(\Input::get('title')),
                'user_id' => \Auth::user()->id,
                'series_order' => $this->post->highestSeriesOrder(\Input::get('series_id'))
            )
        );
        if (is_null($this->post->errors))
        {
            // Save associated tags and categories
            $tags = $this->post->saveRelations('Tag', 'tags');
            if(!empty($tags))
            {
                $this->post->tags()->sync($tags);
            }
            $categories = $this->post->saveRelations('Category', 'categories');
            if(!empty($categories))
            {
                $this->post->categories()->sync($categories);
            }
            return \Redirect::route($this->baseurl.'.index')->with('success', 'Post has been created');
        }

        return \Redirect::route($this->baseurl.'.create')->withInput()->withErrors($this->post->errors);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->data['post'] = $this->post->findOrFail($id);

        $this->data['title'] = 'Show Post: '.$this->data['post']->title;

        return \View::make('bms::posts.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->data['post'] = $this->post->findOrFail($id);
        $this->data['post']->load('tags');
        $this->data['post']->load('categories');

        \View::share('series', array(0 => 'None') + $this->series->orderBy('title', 'asc')->lists('title', 'id'));
        \View::share('post', $this->data['post']);
        \View::share('current_tags', implode(',', $this->data['post']->tags->lists('name')));
        \View::share('current_categories',  implode(',', $this->data['post']->categories->lists('name')));

        $this->data['title'] = 'Edit Post: '.$this->data['post']->title;

        return \View::make('bms::posts.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $this->post = $this->post->findOrFail($id);

        $this->post->uniqueExcept('title');
        $this->post->uniqueExcept('slug');

        $extra_fields = array(
            'slug' => $this->post->slug(\Input::get('title')),
            'series_order' => $this->post->highestSeriesOrder(\Input::get('series_id'), $id)
        );
        if ($this->post->update(\Input::all() + $extra_fields))
        {
            // Save associated tags and categories
            $tags = $this->post->saveRelations('Tag', 'tags');
            if(!empty($tags))
            {
                $this->post->tags()->sync($tags);
            }
            $categories = $this->post->saveRelations('Category', 'categories');
            if(!empty($categories))
            {
                $this->post->categories()->sync($categories);
            }
            return \Redirect::route($this->baseurl.'.index')->with('success', 'The item has been updated.');
        }

        return \Redirect::route($this->baseurl.'.edit', array($id))->withInput()->withErrors($this->post->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = $this->post->find($id);

        if ($post->exists())
        {
            $post->categories()->detach();
            $post->tags()->detach();
            $post->delete();
            return \Redirect::route($this->baseurl.'.index')->with('success', 'The item has been deleted.');
        }

        return \Redirect::route($this->baseurl.'.index')->withErrors('The item you tried to delete does not exist.');
    }
}
