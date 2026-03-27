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

class VoteOption extends Model
{
	protected $fillable = [
		'member_id',
		'value',
		'type',
	];

	public function candidate(): BelongsTo
	{
		return $this->belongsTo(Member::class);
	}

	public function votes(): HasMany
	{
		return $this->hasMany(Vote::class);
	}

	public function ballots(): BelongsToMany
	{
		return $this->belongsToMany(Ballot::class);
	}
}
