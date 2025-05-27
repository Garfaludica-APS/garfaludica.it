<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Models\Booking;
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
		Schema::create('room_reservations', function(Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Booking::class)->constrained()->cascadeOnUpdate()->restictOnDelete();
			$table->foreignIdFor(RoomOption::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
			$table->date('checkin_date');
			$table->date('checkout_date');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('room_reservations');
	}
};
