<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'ballot_id',
		'member_id',
		'vote_option_id',
	];

	public function voter(): BelongsTo
	{
		return $this->belongsTo(Member::class);
	}

	public function voteOption(): BelongsTo
	{
		return $this->belongsTo(VoteOption::class);
	}

	public function ballot(): BelongsTo
	{
		return $this->belongsTo(Ballot::class);
	}
}
