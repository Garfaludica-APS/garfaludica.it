<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifyEmail extends Model
{
	protected $fillable = [
		'email',
	];
}
