<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
			$this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
			$this->app->register(TelescopeServiceProvider::class);
		}
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Vite::prefetch();

		/** @var Application $app */
		$app = $this->app;

		DB::prohibitDestructiveCommands($app->isProduction());

		Model::shouldBeStrict($app->isLocal());
		Model::automaticallyEagerLoadRelationships($app->isProduction());
	}
}
