<?php

use Sorora\Bms\Models\Series;

use Way\Tests\Factory;

class SeriesTest extends TestCase {
    use Way\Tests\ModelHelpers;

    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = 'Series';
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public static function tearDownAfterClass()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('migrate', array('--bench' => 'sorora/aurp'));
        Artisan::call('migrate', array('--bench' => 'sorora/bms'));
    }

    public function testHasManyUsers()
    {
        $this->assertHasMany('posts', 'Sorora\Bms\Models\\'.$this->model);
    }

    public function testInvalidWIthoutTitle()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('title' => null));

        $this->assertNotValid($item);
    }

    public function testInvalidWithTitleOfLessThanThreeChars()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('title' => 'Fo'));

        $this->assertNotValid($item);
    }

    public function testValidWithAllFields()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model);

        $this->assertValid($item);
    }
}