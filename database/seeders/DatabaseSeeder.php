<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$this->call([
			HotelSeeder::class,
			GobCon2025Seeder::class,
			// RoomSeeder::class,
			// RoomOptionSeeder::class,
			// MealSeeder::class,
			// MealOptionSeeder::class,
			// IncludedMealSeeder::class,
		]);
	}
}
