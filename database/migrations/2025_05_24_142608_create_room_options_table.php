<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('room_options', function(Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Room::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('name');
			$table->string('description')->nullable();
			$table->decimal('price');
			$table->unsignedInteger('capacity');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('room_options');
	}
};
