<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Hotel extends Model
{
	protected $fillable = [
		'name',
	];

	public function rooms(): HasMany
	{
		return $this->hasMany(Room::class);
	}

	public function meals(): HasMany
	{
		return $this->hasMany(Meal::class);
	}

	public function roomOptions(): HasManyThrough
	{
		return $this->throughRooms()->hasOptions();
	}

	public function roomReservations(): HasManyThrough
	{
		return $this->throughRooms()->hasReservations();
	}

	public function mealReservations(): HasManyThrough
	{
		return $this->throughMeals()->hasReservations();
	}
}
