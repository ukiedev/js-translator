<?php

namespace Webkid\JsTranslator;

use Illuminate\Support\ServiceProvider;

class JsTranslatorServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/js/lang.js' => public_path('jstranslator/lang.js'),
		], 'public');
	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['jstranslator'] = $this->app->share(function ($app)
		{
			$langs = $app['path.base'].'/resources/lang/' . \App::getLocale();

			return new JsTranslator($langs, $app['files']);
		});
	}
}
