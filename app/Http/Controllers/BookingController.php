<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
	public function start(Request $request, Booking $booking): RedirectResponse
	{
		$closeDate = config('gobcon.portal_closes_at', null);
		if ($closeDate !== null) {
			$closeDate = ($closeDate instanceof Carbon) ? $closeDate : Carbon::parse($closeDate);
			if ($closeDate->isPast())
				abort(403);
		}

		$validated = $request->validate([
			'email' => 'required|max:254|email:strict,dns,spoof',
		]);

		$booking = Booking::whereEmail($validated['email'])
			->whereStatus(BookingStatus::START)->first();

		if (!$booking)
			$booking = Booking::create([
				'email' => $validated['email'],
			]);

		// Mail::to($booking->email)->send(new StartBooking($booking));

		return redirect()->back();
	}

	public function index(Request $request, Booking $booking): RedirectResponse
	{
		match ($booking->status) {
			BookingStatus::START => $routeName = 'gobcon.booking.rooms.index',
			BookingStatus::ROOMS => $routeName = 'gobcon.booking.rooms.index',
			BookingStatus::MEALS => $routeName = 'gobcon.booking.meals.index',
			BookingStatus::BILLING => $routeName = 'gobcon.booking.billing.index',
			BookingStatus::SUMMARY => $routeName = 'gobcon.booking.summary',
			default => abort(404),
		};

		if ($booking->status === BookingStatus::START) {
			$booking->status = BookingStatus::ROOMS;
			$booking->expires_at = Carbon::now()->addMinutes(config('gobcon.booking_expiration_minutes', 30));
			$booking->save();
		}

		return redirect()->route($routeName, [
			'booking' => $booking,
			'sessionLifetimeSeconds' => floor(now()->diffInSeconds($booking->expires_at)),
		]);
	}

	public function summary(Request $request, Booking $booking): Response
	{
		$booking->status = BookingStatus::SUMMARY;
		$booking->save();

		$booking->loadMissing([
			'billingInfo',
			'discountCode',
			'mealReservations',
			'mealReservations.mealOption',
			'mealReservations.mealOption.meal',
			'mealReservations.mealOption.meal.hotel',
			'roomReservations',
			'roomReservations.roomOption',
			'roomReservations.roomOption.room',
			'roomReservations.roomOption.room.hotel',
		]);

		$sandbox = config('paypal.mode') === 'sandbox';

		return Inertia::render('GobCon/Booking/Summary', [
			'booking' => $booking,
			'sandbox' => $sandbox,
			'pp_client_id' => $sandbox ? config('paypal.sandbox.client_id') : config('paypal.live.client_id'),
			'sessionLifetimeSeconds' => floor(now()->diffInSeconds($booking->expires_at)),
		]);
	}

	public function success(Request $request, Booking $booking): Response
	{
		return Inertia::render('GobCon/Booking/Success', [
			'booking' => $booking,
		]);
	}

	public function aborted(Request $request, Booking $booking): Response
	{
		if ($booking->status === BookingStatus::PAYMENT) {
			$booking->status = BookingStatus::CANCELLED;
			$booking->save();
		}

		return Inertia::render('GobCon/Booking/Aborted', [
			'booking' => $booking,
		]);
	}

	public function terminate(Request $request, Booking $booking): RedirectResponse
	{
		$booking->delete();

		return redirect()->route(App::isLocale('it') ? 'gobcon.home' : 'en.gobcon.home')->with('flash', [
			'message' => __('gobcon.booking.expired'),
			'style' => 'info',
			'location' => 'modal',
		]);
	}

	public function reset(Request $request, Booking $booking): RedirectResponse
	{
		DB::transaction(function() use ($booking) {
			$booking->roomReservations()->delete();
			$booking->mealReservations()->delete();
			$booking->billingInfo()->delete();
			$booking->discountCode()->delete();
			$booking->expires_at = Carbon::now()->addMinutes(config('gobcon.booking_expiration_minutes', 30));
			$booking->save();
		});

		return redirect()->back();
	}

	public function manage(Request $request, Booking $booking): Response
	{
		if (\in_array($booking->status, [
			BookingStatus::REFUND_REQUESTED,
			BookingStatus::REFUNDED,
		]))
			return Inertia::render('GobCon/Booking/Refund', [
				'refunded' => $booking->status === BookingStatus::REFUNDED,
			]);

		$booking->loadMissing([
			'billingInfo',
			'discountCode',
			'mealReservations',
			'mealReservations.mealOption',
			'mealReservations.mealOption.meal',
			'mealReservations.mealOption.meal.hotel',
			'roomReservations',
			'roomReservations.roomOption',
			'roomReservations.roomOption.room',
			'roomReservations.roomOption.room.hotel',
		]);

		$refundable = true;
		foreach ($booking->roomReservations as $roomReservation) {
			if ($roomReservation->checkin_date->isPast()) {
				$refundable = false;
				break;
			}
		}

		// $countries = Country::all();

		return Inertia::render('GobCon/Booking/Manage', [
			'booking' => $booking,
			'refundable' => $refundable,
			// 'countries' => $countries,
		]);
	}

	public function refund(Request $request, Booking $booking): RedirectResponse
	{
		$booking->status = BookingStatus::REFUND_REQUESTED;
		$booking->save();

		return redirect()->back();
	}
}
