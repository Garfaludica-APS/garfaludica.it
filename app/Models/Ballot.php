<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ballot extends Model
{
	use HasUuids;
	protected $fillable = [
		'question',
		'type',
		'status',
		'max_votes',
		'previous_ballot_id',
	];

	public function voters(): BelongsToMany
	{
		return $this->belongsToMany(Member::class);
	}

	public function previousBallot(): BelongsTo
	{
		return $this->belongsTo(Ballot::class, 'previous_ballot_id');
	}

	public function nextBallot(): HasOne
	{
		return $this->hasOne(Ballot::class, 'previous_ballot_id');
	}

	public function voteOptions(): BelongsToMany
	{
		return $this->belongsToMany(VoteOption::class, 'vote_option_ballot');
	}

	public function votes(): HasMany
	{
		return $this->hasMany(Vote::class);
	}
}
