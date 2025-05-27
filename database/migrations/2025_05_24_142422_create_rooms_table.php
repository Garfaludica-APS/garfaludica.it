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
		Schema::create('rooms', function(Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Hotel::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('name');
			$table->unsignedInteger('quantity');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('rooms');
	}
};
