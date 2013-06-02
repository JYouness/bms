<?php

use Sorora\Bms\Models\Category;

use Way\Tests\Factory;

class CategoryTest extends TestCase {
    use Way\Tests\ModelHelpers;

    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = 'Category';
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

    public function testBelongsToManyPosts()
    {
        $this->assertBelongsToMany('posts', 'Sorora\Bms\Models\\'.$this->model);
    }

    public function testInvalidWIthoutName()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('name' => null));

        $this->assertNotValid($item);
    }

    public function testInvalidWithNameOfLessThanThreeChars()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('name' => 'Fo'));

        $this->assertNotValid($item);
    }

    public function testInvalidWIthoutSlug()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('slug' => null));

        $this->assertNotValid($item);
    }

    public function testInvalidWithSlugOfLessThanThreeChars()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('slug' => 'Fo'));

        $this->assertNotValid($item);
    }

    public function testInvalidWithSlugThatIsNotAlphaDash()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('slug' => 'Foo Bar !'));

        $this->assertNotValid($item);
    }

    public function testValidWithAllFields()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model);

        $this->assertValid($item);
    }
}