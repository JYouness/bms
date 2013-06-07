<?php

use Way\Tests\Factory;
use Sorora\Empower\Tests\EmpowerTestCase as EmpowerTestCase;

class BlogControllerTest extends EmpowerTestCase {

    protected $url;

    public function setUp()
    {
        parent::setUp();

        $this->url = Config::get('bms::baseurl');
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
        $this->get($this->url);

        $this->assertViewHas('posts');
    }

}
