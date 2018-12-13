<?php

namespace FileFinder\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class FileFinderServiceProvider extends ServiceProvider {
	public function boot() {
		$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
		$this->loadViewsFrom( __DIR__ . '/../resources/views', 'fileFinder');

		$this->publishes([
			__DIR__ . '/../assets' => public_path('file_finder')
		], 'public');
	}

	public function register() {

	}
}