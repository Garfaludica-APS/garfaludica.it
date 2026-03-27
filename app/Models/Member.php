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

class Member extends Model
{
	protected $fillable = [
		'id',
		'name',
		'email',
		'is_voter',
		'is_candidate',
	];
	protected $casts = [
		'is_voter' => 'boolean',
		'is_candidate' => 'boolean',
	];

	public function delegators(): HasMany
	{
		return $this->hasMany(Member::class, 'delegate_id');
	}

	public function delegate(): BelongsTo
	{
		return $this->belongsTo(Member::class, 'delegate_id');
	}

	public function candidateVoteOptions(): HasMany
	{
		return $this->hasMany(VoteOption::class);
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
