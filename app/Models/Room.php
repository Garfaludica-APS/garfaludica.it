<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Room extends Model
{
	protected $fillable = [
		'name',
		'quantity',
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
		return $this->hasMany(RoomOption::class);
	}
}
