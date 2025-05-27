<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Models\Booking;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('billing_infos', function(Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Booking::class)->unique()->constrained()->cascadeOnUpdate()->restrictOnDelete();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('tax_id', 20);
			$table->string('address_line_1');
			$table->string('address_line_2')->nullable();
			$table->string('city');
			$table->string('state');
			$table->string('postal_code');
			$table->string('country_code', 2);
			$table->string('email');
			$table->string('phone', 15)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('billing_infos');
	}
};
