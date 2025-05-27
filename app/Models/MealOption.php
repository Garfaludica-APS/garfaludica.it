<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use App\Enums\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class MealOption extends Model
{
	protected $fillable = [
		'name',
		'menu',
		'price',
	];
	protected $hidden = [
		'meal_id',
	];

	public function meal(): BelongsTo
	{
		return $this->belongsTo(Meal::class);
	}

	public function hotel(): HasOneThrough
	{
		return $this->throughMeal()->hasHotel();
	}

	public function reservations(): HasMany
	{
		return $this->hasMany(MealReservation::class);
	}

	public function bookings(): HasManyThrough
	{
		return $this->throughReservations()->hasBookings();
	}

	protected function casts(): array
	{
		return [
			'menu' => Menu::class,
			'price' => 'decimal:2',
		];
	}
}
