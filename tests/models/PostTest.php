<?php

use Sorora\Bms\Models\Post;

use Way\Tests\Factory;

class PostTest extends TestCase {
    use Way\Tests\ModelHelpers;

    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = 'Post';
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

    public function testBelongsToSeries()
    {
        $this->assertBelongsTo('series', 'Sorora\Bms\Models\\'.$this->model);
    }

    public function testBelongsToManyTags()
    {
        $this->assertBelongsToMany('tags', 'Sorora\Bms\Models\\'.$this->model);
    }

    public function testBelongsToManyCategories()
    {
        $this->assertBelongsToMany('categories', 'Sorora\Bms\Models\\'.$this->model);
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

    public function testInvalidWithoutSlug()
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

    public function testInvalidWithoutContent()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('content' => null));

        $this->assertNotValid($item);
    }

    public function testInvalidWithContentOfLessThanTenChars()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('slug' => 'This foob'));

        $this->assertNotValid($item);
    }

    public function testInvalidWithoutPublished()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('published' => null));

        $this->assertNotValid($item);
    }

    public function testInvalidWithPublishedNotZeroOrOne()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('published' => 2));

        $this->assertNotValid($item);
    }

    public function testValidWithAllFields()
    {
        $item = Factory::make('Sorora\Bms\Models\\'.$this->model, array('user_id' => 1));

        $this->assertValid($item);
    }
}