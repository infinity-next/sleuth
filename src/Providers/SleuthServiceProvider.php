<?php namespace InfinityNext\Sleuth\Providers;

use InfinityNext\Sleuth\FileSleuth;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SleuthServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		// $this->publishes(array(
		// 	__DIR__.'/../../config/config.php' => config_path('image.php')
		// ));
	}
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;
		
		// merge default config
		// $this->mergeConfigFrom(
		// 	__DIR__.'/../../config/config.php',
		// 	'image'
		// );
		
		// create image
		$app['sleuth'] = $app->share(function ($app) {
			return new FileSleuth(); //$app['config']->get('sleuth'));
		});
		
		$app->alias('sleuth', 'InfinityNext\Sleuth\FileSleuth');
	}
	
	/**6
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('sleuth');
	}
}
