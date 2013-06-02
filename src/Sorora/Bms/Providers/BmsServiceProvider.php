<?php namespace Sorora\Bms\Providers;

use Illuminate\Support\ServiceProvider;

class BmsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('sorora/bms');

		include __DIR__.'/../../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register package configuration location
		$this->app['config']->package('sorora/bms', __DIR__.'/../../../config');
		// Register package view location
   		$this->app['view']->addNamespace('bms', __DIR__.'/../../../views');

   		// Bindings for Repositories
		$this->app->bind(
			'Sorora\Bms\Models\Repositories\Series\SeriesRepositoryInterface',
			'Sorora\Bms\Models\Repositories\Series\EloquentSeriesRepository'
		);
		$this->app->bind(
			'Sorora\Bms\Models\Repositories\Post\PostRepositoryInterface',
			'Sorora\Bms\Models\Repositories\Post\EloquentPostRepository'
		);
		$this->app->bind(
			'Sorora\Bms\Models\Repositories\Category\CategoryRepositoryInterface',
			'Sorora\Bms\Models\Repositories\Category\EloquentCategoryRepository'
		);
		$this->app->bind(
			'Sorora\Bms\Models\Repositories\Tag\TagRepositoryInterface',
			'Sorora\Bms\Models\Repositories\Tag\EloquentTagRepository'
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}