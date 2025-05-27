<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class RoomOption extends Model
{
	protected $fillable = [
		'name',
		'description',
		'price',
		'capacity',
	];
	protected $casts = [
		'price' => 'decimal:2',
	];
	protected $hidden = [
		'room_id',
	];

	public function room(): BelongsTo
	{
		return $this->belongsTo(Room::class);
	}

	public function hotel(): HasOneThrough
	{
		return $this->throughRoom()->hasHotel();
	}

	public function includedMeals(): BelongsToMany
	{
		return $this->belongsToMany(Meal::class);
	}

	public function reservations(): HasMany
	{
		return $this->hasMany(RoomReservation::class);
	}

	public function bookings(): HasManyThrough
	{
		return $this->throughReservations()->hasBookings();
	}
}
