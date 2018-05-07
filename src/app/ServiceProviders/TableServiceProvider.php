<?php

namespace Kostant\Table\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../../resources/config/table.php' => config_path('table.php'),
		]);

		$this->mergeConfigFrom(
			__DIR__ . '/../../resources/config/table.php', 'table'
		);

		$this->loadRoutesFrom(__DIR__ . '/../../resources/routes/routes.php');
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
