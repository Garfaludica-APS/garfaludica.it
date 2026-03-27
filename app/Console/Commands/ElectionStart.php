<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Console\Commands;

use App\Models\Ballot;
use App\Models\Member;
use App\Models\VoteOption;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ElectionStart extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'election:start';

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
		DB::transaction(function() {
			$candidatesCount = Member::where('is_candidate', true)->count();
			$ballots = Ballot::all();
			foreach ($ballots as $ballot) {
				$ballot->delete();
			}
			$options = [];
			$options[] = VoteOption::create([
				'member_id' => null,
				'value' => 3,
			]);
			if ($candidatesCount >= 5)
				$options[] = VoteOption::create([
					'member_id' => null,
					'value' => 5,
				]);
			if ($candidatesCount >= 7)
				$options[] = VoteOption::create([
					'member_id' => null,
					'value' => 7,
				]);
			if ($candidatesCount >= 9)
				$options[] = VoteOption::create([
					'member_id' => null,
					'value' => 9,
				]);
			$options[] = VoteOption::create([
				'member_id' => null,
				'value' => null,
				'type' => 'abstain',
			]);
			$ballot = Ballot::create([
				'question' => 'Da quanti membri volete che sia composto il nuovo Consiglio Direttivo?',
				'type' => 'standard',
				'status' => 'current',
				'max_votes' => 1,
				'previous_ballot_id' => null,
			]);
			$ballot->voteOptions()->attach($options);
		});
	}
}
