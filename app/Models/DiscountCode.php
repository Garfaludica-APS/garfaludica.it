<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCode extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'key',
		'amount',
		'percentual',
	];
	protected $casts = [
		'amount' => 'decimal:2',
		'percentual' => 'boolean',
	];

	public function booking(): HasOne
	{
		return $this->hasOne(Booking::class);
	}
}
