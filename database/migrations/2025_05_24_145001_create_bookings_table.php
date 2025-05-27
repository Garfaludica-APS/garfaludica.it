<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Models\DiscountCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('bookings', function(Blueprint $table) {
			$table->id();
			$table->uuid('uuid')->unique();
			$table->string('email');
			$table->enum('status', ['start', 'rooms', 'meals',
				'billing', 'summary', 'payment', 'completed',
				'failed', 'cancelled', 'refund_requested',
				'refunded'])->default('start');
			$table->text('notes')->nullable();
			$table->foreignIdFor(DiscountCode::class)->nullable()->unique()->constrained()->cascadeOnUpdate()->nullOnDelete();
			$table->string('pp_order_id', 36)->nullable()->unique();
			$table->timestamp('expires_at');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('bookings');
	}
};
