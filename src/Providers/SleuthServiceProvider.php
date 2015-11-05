<?php namespace InfinityNext\Sleuth\Providers;

use InfinityNext\Sleuth\FileSleuth;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SleuthServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('sleuth', function() {
			return new FileSleuth();
		});
		
		$this->app->alias('sleuth', 'InfinityNext\Sleuth\FileSleuth');
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('sleuth', 'InfinityNext\Sleuth\FileSleuth');
	}
}
