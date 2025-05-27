<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class MealReservation extends Model
{
	protected $fillable = [
		'meal_date',
	];
	protected $casts = [
		'meal_date' => 'date',
	];
	protected $hidden = [
		'booking_id',
		'meal_option_id',
	];

	public function booking(): BelongsTo
	{
		return $this->belongsTo(Booking::class);
	}

	public function mealOption(): BelongsTo
	{
		return $this->belongsTo(MealOption::class);
	}

	public function meal(): HasOneThrough
	{
		return $this->throughMealOption()->hasMeal();
	}

	// TODO: has-many-deep
	public function hotel(): HasOneThrough
	{
		return $this->throughMeal()->hasHotel();
	}

	protected function price(): Attribute
	{
		return Attribute::make(
			get: fn() => $this->mealOption->price,
		)->shouldCache();
	}
}
