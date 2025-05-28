<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Squire\Models\Country;
use Squire\Repository;

class CountriesItServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void {}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		Repository::registerSource(Country::class, 'it', __DIR__ . '/resources/data.csv');
	}
}
