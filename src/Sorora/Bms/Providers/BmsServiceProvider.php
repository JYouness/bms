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