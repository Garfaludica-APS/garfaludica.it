<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Jobs;

use App\Models\Ballot;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ComputeResults implements ShouldBeUnique, ShouldQueue
{
	use Queueable;

	/**
	 * Create a new job instance.
	 */
	public function __construct(public Ballot $ballot) {}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		$ballot = $this->ballot;
		$ballot->load('previousBallot', 'votes', 'voteOptions');
		if ($ballot->previous_ballot) {
			$rank = $ballot->previous_ballot->results['rank'];
		} else {
			foreach ($ballot->vote_options as $option) {
				if ($option->type === 'blank') {
					$optname = 'Schede bianche';
					$tiebreaker = 10000;
				} elseif ($option->type === 'abstain') {
					$optname = 'Astenuti';
					$tiebreaker = 20000;
				} elseif ($ballot->type === 'election') {
					$option->load('candidate');
					$optname = $option->candidate->name . ' (' . $option->candidate->id . ')';
					$tiebreaker = $option->candidate->id;
				} else {
					switch ($option->value) {
						case 3:
							$optname = '3 (tre)';
							$tiebreaker = -3;
							break;
						case 5:
							$optname = '5 (cinque)';
							$tiebreaker = -5;
							break;
						case 7:
							$optname = '7 (sette)';
							$tiebreaker = -7;
							break;
						case 9:
							$optname = '9 (nove)';
							$tiebreaker = -9;
							break;
						default:
							$optname = $option->value;
							$tiebreaker = 0;
							break;
					}
				}
				$rank[] = [
					'id' => $option->id,
					'name' => $optname,
					'tiebreaker' => $tiebreaker,
					'votes' => 0,
					'voters' => [],
					'relative' => 0,
					'type' => $option->type,
				];
			}
		}
		$results = [
			'rank' => $rank,
			'ballots' => [],
		];
		if ($ballot->previous_ballot) {
			$results = $ballot->previous_ballot->results;
			$current = [];
			$lastBallot = end($results['ballots']);
			$currentVOs = $ballot->voteOptions;
			$repeat = true;
			foreach ($lastBallot as $option) {
				foreach ($currentVOs as $cur) {
					if ($cur->id === $option['id']) {
						continue 2;
					}
				}
				$repeat = false;
				break;
			}
			foreach ($currentVOs as $option) {
				if ($option->type === 'blank') {
					$optname = 'Schede bianche';
					$tiebreaker = 10000;
				} elseif ($option->type === 'abstain') {
					$optname = 'Astenuti';
					$tiebreaker = 20000;
				} elseif ($ballot->type === 'election') {
					$option->load('candidate');
					$optname = $option->candidate->name . ' (' . $option->candidate->id . ')';
					$tiebreaker = $option->candidate->id;
				} else {
					switch ($option->value) {
						case 3:
							$optname = '3 (tre)';
							$tiebreaker = -3;
							break;
						case 5:
							$optname = '5 (cinque)';
							$tiebreaker = -5;
							break;
						case 7:
							$optname = '7 (sette)';
							$tiebreaker = -7;
							break;
						case 9:
							$optname = '9 (nove)';
							$tiebreaker = -9;
							break;
						default:
							$optname = $option->value;
							$tiebreaker = 0;
							break;
					}
				}
				$current[$option->id] = [
					'id' => $option->id,
					'name' => $optname,
					'tiebreaker' => $tiebreaker,
					'votes' => 0,
					'voters' => [],
					'relative' => 0,
					'type' => $option->type,
				];
			}

			$maxVotes = 0;
			foreach ($ballot->votes as $vote) {
				$vote->load('voteOption', 'voter');
				++$current[$vote->voteOption->id]['votes'];
				if ($current[$vote->voteOption->id]['votes'] > $maxVotes) {
					$maxVotes = $current[$vote->voteOption->id]['votes'];
				}
				if ($ballot->type === 'standard')
					$current[$vote->voteOption->id]['voters'][] = $vote->voter;
			}

			usort($current, function($a, $b) {
				if ($a['type'] === 'blank' && $b['type'] === 'abstain') {
					return -1;
				}
				if ($a['type'] === 'abstain' && $b['type'] === 'blank') {
					return 1;
				}
				if ($a['type'] === 'blank' || $a['type'] === 'abstain') {
					return 1;
				}
				if ($b['type'] === 'blank' || $b['type'] === 'abstain') {
					return -1;
				}
				$voteDiff = $b['votes'] - $a['votes'];
				if ($voteDiff !== 0) {
					return -$voteDiff;
				}
				return $b['tiebreaker'] - $a['tiebreaker'];
			});

			$equals = [];
			$prevVotes = null;
			$blankOption = null;
			$abstainOption = null;
			foreach ($current as $key => $option) {
				if ($option['type'] === 'blank') {
					$blankOption = $option;
					continue;
				}
				if ($option['type'] === 'abstain') {
					$abstainOption = $option;
					continue;
				}
				$current[$key]['relative'] = round($option['votes'] / $maxVotes * 100, 2);
				if ($repeat)
				continue;
				if ($prevVotes !== null) {
					if ($current[$key]['votes'] === $prevVotes) {
						$equals[$prevVotes][] = $current[$key];
					}
				}
				$prevVotes = $current[$key]['votes'];
			}
			foreach ($equals as $equalOptions) {
				if (\count($equalOptions) <= 1) {
					continue;
				}
				$newBallot = Ballot::create([
					'question' => 'Ballottaggio tra ' . implode(', ', array_map(fn($opt) => $opt['name'], $equalOptions)),
					'type' => $ballot->type,
					'previous_ballot_id' => $ballot->id,
					'status' => 'queued',
					'max_votes' => 1,
				]);
				$newBallot->voteOptions()->attach([...array_map(fn($opt) => $opt['id'], $equalOptions), $blankOption, $abstainOption]);
				if ($ballot->type === 'standard')
				break;
			}

			$results['ballots'][] = $current;

			$rank = $results['rank'];
			usort($rank, function($a, $b) use ($current) {
				if ($a['type'] === 'blank' && $b['type'] === 'abstain') {
					return -1;
				}
				if ($a['type'] === 'abstain' && $b['type'] === 'blank') {
					return 1;
				}
				if ($a['type'] === 'blank' || $a['type'] === 'abstain') {
					return 1;
				}
				if ($b['type'] === 'blank' || $b['type'] === 'abstain') {
					return -1;
				}
				$voteDiff = $b['votes'] - $a['votes'];
				if ($voteDiff !== 0) {
					return -$voteDiff;
				}
				$newVoteDiff = $current[$a['id']]['votes'] - $current[$b['id']]['votes'];
				if ($newVoteDiff !== 0) {
					return -$newVoteDiff;
				}
				return $b['tiebreaker'] - $a['tiebreaker'];
			});
			$results['rank'] = $rank;
			$ballot->results = $results;
			$ballot->save();
		} else {
			$results = [
				'rank' => [],
				'ballots' => [],
			];
		}

		$nextBallot = Ballot::where('status', 'queued')->last();
		$nextBallot->status = 'current';
		$nextBallot->save();
	}
}
