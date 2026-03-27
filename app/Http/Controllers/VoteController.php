<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use App\Jobs\ComputeResults;
use App\Models\Ballot;
use App\Models\Member;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class VoteController extends Controller
{
	public function electionStart(Request $request, string $token, Member $member)
	{
		// if (!$request->hasValidSignature())
		// 	abort(403);
		if (!$member->is_voter)
			abort(403);
		if ($token !== config('garfaludica.vote_token'))
			abort(403);
		$request->session()->regenerate();
		$request->session()->put('member_id', $member->id);
		$voteToken = Str::random(32);
		$request->session()->put('vote_token', $voteToken);
		return Inertia::render('Vote/ElectionStart', [
			'token' => $voteToken,
			'member' => $member,
		]);
	}

	public function electionVerify(Request $request, string $token)
	{
		if ($token !== $request->session()->get('vote_token'))
			abort(403);
		$member = Member::findOrFail($request->session()->get('member_id'));
		if (!$member->is_voter)
			abort(403);
		return to_route('vote.election.queue', [
			'token' => $token,
		]);
	}

	public function electionQueue(Request $request, string $token)
	{
		if ($token !== $request->session()->get('vote_token'))
			abort(403);
		$member = Member::findOrFail($request->session()->get('member_id'));
		if (!$member->is_voter)
			abort(403);
		$ballot = Ballot::where('status', 'current')->orderBy('id')->first();
		if (!$ballot) {
			$ballot = Ballot::where('status', 'completed')->orderBy('id')->last();
			if (!$ballot) {
				return Inertia::render('Vote/ElectionQueue', [
					'waiting_results' => false,
				]);
			}
			if (!$ballot->results) {
				return Inertia::render('Vote/ElectionQueue', [
					'waiting_results' => true,
				]);
			}
			return to_route('vote.ballot.results', [
				'ballot' => $ballot,
			]);
		}
		$ballot->load('voters');
		$voted = false;
		foreach ($ballot->voters as $voter) {
			if ($voter->id === $member->id) {
				$voted = true;
				break;
			}
		}
		if ($voted) {
			return Inertia::render('Vote/ElectionQueue', [
				'waiting_results' => true,
			]);
		}
		$ballot->load('previousBallot');
		if ($ballot->previousBallot && $ballot->previousBallot->status === 'completed') {
			return to_route('vote.ballot.results', [
				'ballot' => $ballot->previousBallot,
			]);
		}
		return to_route('vote.ballot.index', [
			'ballot' => $ballot,
		]);
	}

	public function ballotIndex(Request $request, Ballot $ballot)
	{
		$member = Member::findOrFail($request->session()->get('member_id'));
		if (!$member->is_voter)
			abort(403);
		if ($ballot->status !== 'current')
			abort(403);
		if ($ballot->voters()->where('member_id', $member->id)->exists())
			abort(403);

		return Inertia::render('Vote/BallotIndex', [
			'ballot' => $ballot->load('voteOptions'),
		]);
	}

	public function ballotVote(Request $request, Ballot $ballot)
	{
		$member = Member::findOrFail($request->session()->get('member_id'));
		if (!$member->is_voter)
			abort(403);
		if ($ballot->status !== 'current')
			abort(403);
		if ($ballot->voters()->where('member_id', $member->id)->exists())
			abort(403);

		$validated = $request->validate([
			'selected' => 'required|array',
			'selected.*' => 'exists:vote_options,id',
		]);

		$selected = $validated['selected'];

		$ballot->load('voteOptions');
		$options = $ballot->vote_options;
		$abstainVO = null;
		$blankVO = null;
		foreach ($options as $option) {
			if ($option->type === 'abstain') {
				$abstainVO = $option;
			} elseif ($option->type === 'blank') {
				$blankVO = $option;
			}
		}
		$voteOptions = [];
		if ($abstainVO && \in_array($abstainVO->id, $selected)) {
			$voteOptions = [$abstainVO];
		} elseif ($blankVO && \in_array($blankVO->id, $selected)) {
			$voteOptions = [$blankVO];
		} elseif (\count($selected) > $ballot->max_votes) {
			return back()->withErrors(['selected' => 'Non puoi inviare più di ' . $ballot->max_votes . ' voti.']);
		} else {
			foreach ($options as $option) {
				if (\in_array($option->id, $selected)) {
					$voteOptions[] = $option;
				}
			}
		}

		$member->load('delegators');
		$delegators = $member->delegators;
		$voterIds = [];
		$voterIds[] = $member->id;
		foreach ($delegators as $delegator) {
			$voterIds[] = $delegator->id;
		}

		DB::transaction(function() use ($ballot, $voteOptions, $voterIds, $member) {
			$ballot->load('voters');
			$ballot->voters->attach($member->id);
			foreach ($voterIds as $voterId) {
				foreach ($voteOptions as $option) {
					Vote::create([
						'ballot_id' => $ballot->id,
						'member_id' => $ballot->type === 'election' ? null : $voterId,
						'vote_option_id' => $option->id,
					]);
				}
			}
		});

		Cache::lock('vote_lock_' . $ballot->id, 20)->block(30, function() use ($ballot) {
			DB::transaction(function() use ($ballot) {
				if ($ballot->voters()->count() === Member::where('is_voter', true)->count()) {
					$ballot->status = 'completed';
					$ballot->save();
				}
			});
			if ($ballot->voters()->count() === Member::where('is_voter', true)->count()) {
				ComputeResults::dispatch($ballot);
			}
		});

		return to_route('vote.election.queue', [
			'token' => $request->session()->get('vote_token'),
		]);
	}

	public function ballotResults(Request $request, Ballot $ballot)
	{
		$member = Member::findOrFail($request->session()->get('member_id'));
		if (!$member->is_voter)
			abort(403);
		if ($ballot->status !== 'completed' || !$ballot->results)
			abort(403);
		return Inertia::render('Vote/BallotResults', [
			'ballot' => $ballot->load('voteOptions'),
			'next_ballot' => Ballot::where('status', 'current')->orderBy('id')->first(),
		]);
	}
}
