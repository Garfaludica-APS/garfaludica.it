<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Models\Meal;
use App\Models\RoomOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('meal_room_option', function(Blueprint $table) {
			$table->foreignIdFor(RoomOption::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignIdFor(Meal::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->primary(['room_option_id', 'meal_id']);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('meal_room_option');
	}
};
