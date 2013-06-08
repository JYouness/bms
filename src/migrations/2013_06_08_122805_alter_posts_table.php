<?php

use Illuminate\Database\Migrations\Migration;

class AlterPostsTable extends Migration {

	protected $prefix;

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$this->prefix = \Config::get('empower::dbprefix');
		// Create posts table
		Schema::table($this->prefix.'posts', function ($table) {
			$table->string('identifier')->length(16)->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$this->prefix = \Config::get('empower::dbprefix');
		// Drop posts identifier column
		Schema::table($this->prefix.'posts', function ($table) {
			$table->dropColumn('identifier');
		});
	}

}