<?php

use Illuminate\Database\Migrations\Migration;

use Sorora\Aurp\Models\Permission;

class CreateBmsStructure extends Migration {

	protected $prefix;

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$this->prefix = \Config::get('empower::dbprefix');
		// Create series table
		Schema::create($this->prefix.'series', function ($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('title')->length(100);
			$table->timestamps();
		});
		// Create posts table
		Schema::create($this->prefix.'posts', function ($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('series_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('title')->length(250);
			$table->string('slug')->length(250);
			$table->text('content');
			$table->boolean('published')->default(0);
			$table->timestamps();
		});
		// Create tags table
		Schema::create($this->prefix.'tags', function ($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('name')->length(50);
			$table->string('slug')->length(50);
			$table->timestamps();
		});
		// Create categories table
		Schema::create($this->prefix.'categories', function ($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('name')->length(50);
			$table->string('slug')->length(50);
			$table->timestamps();
		});
		// Create post_tag table
		Schema::create($this->prefix.'post_tag', function ($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('post_id')->unsigned();
			$table->integer('tag_id')->unsigned();
		});
		// Create category_post table
		Schema::create($this->prefix.'category_post', function ($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->integer('post_id')->unsigned();
		});

		// Add permissions
		$permissions = array(
			'create_posts' => 'Create Blog Posts',
			'edit_posts' => 'Edit Blog Posts',
			'show_posts' => 'Show Blog Posts',
			'destroy_posts' => 'Destroy Blog Posts',
			'create_series' => 'Create Blog Series',
			'edit_series' => 'Edit Blog Series',
			'show_series' => 'Show Blog Series',
			'destroy_series' => 'Destroy Blog Series'
		);

		foreach($permissions AS $task => $title)
		{
			Permission::create(array('task' => $task, 'title' => $title));
		}

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$this->prefix = \Config::get('empower::dbprefix');
		// Drop users table
		Schema::drop($this->prefix.'series');
		Schema::drop($this->prefix.'posts');
		Schema::drop($this->prefix.'tags');
		Schema::drop($this->prefix.'categories');
		Schema::drop($this->prefix.'post_tag');
		Schema::drop($this->prefix.'category_post');
	}

}