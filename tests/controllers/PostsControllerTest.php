<?php

use Way\Tests\Factory;

class PostsControllerTest extends TestCase {

    protected $model;
    protected $var;
    protected $url;
    protected $route;
    protected $factory;
    protected $mock;

    public function __call($method, $args)
    {
        if (in_array($method, ['get', 'post', 'put', 'patch', 'delete']))
        {
            return $this->call($method, $args[0]);
        }

        throw new BadMethodCallException;
    }

    public function setUp()
    {
        parent::setUp();

        $this->model = 'Post';

        $this->var = strtolower($this->model).'s';

        $this->url = Config::get('empower::baseurl').'/'.$this->var;

        $this->route = Config::get('empower::baseurl').'.'.$this->var;

        $this->factory = 'Sorora\Bms\Models\\'.$this->model;

        $this->mock = $this->mock('Sorora\Bms\Models\Repositories\\'.$this->model.'\\'.$this->model.'RepositoryInterface');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    private function mock($class)
    {
        $mock = Mockery::mock($class);

        $mock->errors = null;

        $this->app->instance($class, $mock);

        return $mock;
    }

    public function testIndex()
    {
        $this->mock
             ->shouldReceive('orderBy')
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('get')
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('count')
             ->once()
             ->andReturn(false);

        $this->get($this->url);

        $this->assertViewHas($this->var);
    }

    public function testCreate()
    {
        $this->get($this->url.'/create');
    }

    public function testStoreFails()
    {
        Input::replace($input = array());

        Auth::shouldReceive('user')
                ->andReturn((object) array('id' => 1));

        $this->mock
             ->shouldReceive('create')
             ->once()
             ->andReturn((object) array('errors' => 'Foo'));

        $this->mock
             ->shouldReceive('slug')
             ->andReturn('foo');

        $this->mock
             ->shouldReceive('highestSeriesOrder')
             ->once()
             ->andReturn(1);

        $this->post($this->url);

        $this->assertRedirectedToRoute($this->route.'.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        Input::replace(Factory::attributesFor($this->factory));

        Auth::shouldReceive('user')
                ->andReturn((object) array('id' => 1));

        $this->mock
             ->shouldReceive('create')
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('slug')
             ->andReturn('foo');

        $this->mock
             ->shouldReceive('highestSeriesOrder')
             ->once()
             ->andReturn(1);

        $this->mock
             ->shouldReceive('saveRelations')
             ->twice()
             ->andReturn(array(1,2,3));

        $this->mock
             ->shouldReceive('categories', 'tags')
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('sync')
             ->twice()
             ->andReturn($this->mock);

        $this->post($this->url);

        $this->assertRedirectedToRoute($this->route.'.index');
    }

    public function testShow()
    {
        $this->mock
             ->shouldReceive('findOrFail')
             ->with(3)
             ->once()
             ->andReturn(Factory::make($this->factory, array('id' => 3)));

        $this->get($this->url.'/3');

        $this->assertViewHas(substr($this->var, 0, -1));
    }

    public function testEdit()
    {
        $this->mock
             ->shouldReceive('findOrFail')
             ->with(3)
             ->once()
             ->andReturn(Factory::make($this->factory, array('id' => 3)));

        $this->get($this->url.'/3/edit', 3);

        $this->assertViewHas(substr($this->var, 0, -1));
    }

    public function testUpdateFails()
    {
        Input::replace(array('title' => '1'));

        $this->mock
             ->shouldReceive('findOrFail')
             ->with(3)
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('uniqueExcept')
             ->with(\Mockery::anyOf('title', 'slug'))
             ->twice();

        $this->mock
             ->shouldReceive('update')
             ->once()
             ->andReturn(false);

        $this->mock
             ->shouldReceive('slug')
             ->andReturn('foo');

        $this->mock
             ->shouldReceive('highestSeriesOrder')
             ->once()
             ->andReturn(1);

        $this->put($this->url.'/3');

        $this->assertRedirectedToRoute($this->route.'.edit', array(3));
        $this->assertSessionHasErrors();
    }

    public function testUpdateSuccess()
    {
        Input::replace(array('title' => 'Foo', 'task' => 'Foo'));

        $this->mock
             ->shouldReceive('findOrFail')
             ->with(3)
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('uniqueExcept')
             ->with(\Mockery::anyOf('title', 'slug'))
             ->twice();

        $this->mock
             ->shouldReceive('update')
             ->once()
             ->andReturn(true);

        $this->mock
             ->shouldReceive('slug')
             ->andReturn('foo');

        $this->mock
             ->shouldReceive('highestSeriesOrder')
             ->once()
             ->andReturn(1);

        $this->mock
             ->shouldReceive('saveRelations')
             ->twice()
             ->andReturn(array(1,2,3));

        $this->mock
             ->shouldReceive('categories', 'tags')
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('sync')
             ->twice()
             ->andReturn($this->mock);

        $this->put($this->url.'/3');

        $this->assertRedirectedToRoute($this->route.'.index');
    }

    public function testDestroyFails()
    {
        $this->mock
             ->shouldReceive('find')
             ->with(3)
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('exists')
             ->once()
             ->andReturn(false);

        $this->delete($this->url.'/3');

        $this->assertRedirectedToRoute($this->route.'.index');
        $this->assertSessionHasErrors();
    }

    public function testDestroySuccess()
    {
        $this->mock
             ->shouldReceive('find')
             ->with(3)
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('exists', 'delete')
             ->once()
             ->andReturn(true);

        $this->mock
             ->shouldReceive('categories', 'tags')
             ->once()
             ->andReturn($this->mock);

        $this->mock
             ->shouldReceive('detach')
             ->twice()
             ->andReturn($this->mock);

        $this->delete($this->url.'/3');

        $this->assertRedirectedToRoute($this->route.'.index');
    }

}
