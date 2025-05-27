<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Models\Hotel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('meals', function(Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Hotel::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->enum('type', ['breakfast', 'lunch', 'dinner']);
			$table->boolean('reservable')->default(true);
			$table->timestamps();
			$table->unique(['hotel_id', 'type']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('meals');
	}
};
