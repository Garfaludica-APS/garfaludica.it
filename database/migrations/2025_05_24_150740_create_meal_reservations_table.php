<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Models\Booking;
use App\Models\MealOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('meal_reservations', function(Blueprint $table) {
			$table->id();
			$table->foreignIdfor(Booking::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
			$table->foreignIdFor(MealOption::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
			$table->date('meal_date');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('meal_reservations');
	}
};
