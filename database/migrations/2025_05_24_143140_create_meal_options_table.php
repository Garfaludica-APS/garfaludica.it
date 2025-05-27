<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Models\Meal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('meal_options', function(Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Meal::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('name');
			$table->enum('menu', ['standard', 'vegetarian', 'vegan']);
			$table->decimal('price');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('meal_options');
	}
};
