<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Middleware;

use App\Enums\BookingState;
use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyBookingState
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Closure(Request): (Response) $next
	 */
	public function handle(Request $request, Closure $next, string ...$allowedStatuses): Response
	{
		$allowedStatuses = array_map(
			fn(string $status) => BookingState::from($status),
			$allowedStatuses
		);

		$bookingId = $request->route('booking');
		if (empty($bookingId))
			abort(404);
		$booking = Booking::firstWhere('uuid', $bookingId);
		if (!$booking)
			abort(404);

		if ($booking->expires_at->isPast()) {
			$booking->delete();
			abort(410);
		}

		if (!\in_array($booking->status, $allowedStatuses, true))
			abort(403);

		return $next($request);
	}
}
