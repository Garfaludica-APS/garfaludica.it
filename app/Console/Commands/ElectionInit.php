<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Console\Commands;

use App\Mail\ElectionInitMail;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ElectionInit extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'election:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$voters = Member::where('is_voter', true)->get();
		foreach ($voters as $voter) {
			Mail::to($voter->email)
				->queue(new ElectionInitMail($voter->vote_url));
		}
	}
}
