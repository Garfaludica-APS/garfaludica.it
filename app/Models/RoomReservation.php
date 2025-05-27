<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class RoomReservation extends Model
{
	protected $fillable = [
		'checkin_date',
		'checkout_date',
	];
	protected $casts = [
		'checkin_date' => 'date',
		'checkout_date' => 'date',
	];
	protected $hidden = [
		'booking_id',
		'room_option_id',
	];

	public function booking(): BelongsTo
	{
		return $this->belongsTo(Booking::class);
	}

	public function roomOption(): BelongsTo
	{
		return $this->belongsTo(RoomOption::class);
	}

	public function includedMeals(): HasManyThrough
	{
		return $this->throughRoomOption()->hasIncludedMeals();
	}

	public function room(): HasOneThrough
	{
		return $this->throughRoomOption()->hasRoom();
	}

	// TODO: has-many-deep
	public function hotel(): HasOneThrough
	{
		return $this->throughRoom()->hasHotel();
	}

	protected function price(): Attribute
	{
		return Attribute::make(
			get: fn() => $this->roomOption->price,
		)->shouldCache();
	}
}
