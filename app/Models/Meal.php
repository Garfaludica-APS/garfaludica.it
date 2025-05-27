<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use App\Enums\MealType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Meal extends Model
{
	protected $fillable = [
		'type',
		'reservable',
	];
	protected $hidden = [
		'hotel_id',
	];

	public function hotel(): BelongsTo
	{
		return $this->belongsTo(Hotel::class);
	}

	public function reservations(): HasManyThrough
	{
		return $this->throughOptions()->hasReservations();
	}

	public function options(): HasMany
	{
		return $this->hasMany(MealOption::class);
	}

	public function roomOptions(): BelongsToMany
	{
		return $this->belongsToMany(RoomOption::class);
	}

	// TODO: has-many-deep
	public function bookings(): HasManyThrough
	{
		return $this->throughReservations()->hasBookings();
	}

	protected function casts(): array
	{
		return [
			'type' => MealType::class,
			'reservable' => 'boolean',
		];
	}
}
