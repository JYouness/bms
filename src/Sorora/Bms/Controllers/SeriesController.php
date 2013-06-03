<?php namespace Sorora\Bms\Controllers;

use Sorora\Empower\Controllers\EmpowerController as EmpowerController;

use Sorora\Bms\Models\Repositories\Series\SeriesRepositoryInterface as Series;

class SeriesController extends EmpowerController {

    protected $series;

    public function __construct(Series $series)
    {
        parent::__construct();

        $this->series = $series;

        $this->data['baseurl'] = $this->baseurl .= 'series';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->data['title'] = 'Series';

        $this->data['series'] = $this->series->all();

        return \View::make($this->viewFromConfig('bms', 'series', 'index'), $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['title'] = 'Create Series';

        return \View::make($this->viewFromConfig('bms', 'series', 'create'), $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->series = $this->series->create(\Input::all());
        if (is_null($this->series->errors))
        {
            return \Redirect::route($this->baseurl.'.index')->with('success', 'Series has been created');
        }

        return \Redirect::route($this->baseurl.'.create')->withInput()->withErrors($this->series->errors);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->data['series'] = $this->series->findOrFail($id);

        $this->data['title'] = 'Show Series: '.$this->data['series']->title;

        return \View::make($this->viewFromConfig('bms', 'series', 'show'), $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->data['series'] = $this->series->findOrFail($id);

        $this->data['title'] = 'Edit Series: '.$this->data['series']->title;

        return \View::make($this->viewFromConfig('bms', 'series', 'edit'), $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $this->series = $this->series->findOrFail($id);
        
        if ($this->series->update(\Input::all()))
        {
            return \Redirect::route($this->baseurl.'.index')->with('success', 'The item has been updated.');
        }

        return \Redirect::route($this->baseurl.'.edit', array($id))->withInput()->withErrors($this->series->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $series = $this->series->find($id);

        if ($series->exists())
        {
            $series->delete();
            return \Redirect::route($this->baseurl.'.index')->with('success', 'The item has been deleted.');
        }

        return \Redirect::route($this->baseurl.'.index')->withErrors('The item you tried to delete does not exist.');
    }
}
