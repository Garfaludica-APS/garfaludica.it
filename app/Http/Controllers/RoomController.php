<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomReservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
	public function index(Request $request, Booking $booking): Response
	{
		return Inertia::render('GobCon/Booking/Rooms');
	}

	public function store(Request $request, Booking $booking): RedirectResponse
	{
		return redirect()->back();
	}

	public function destroy(Request $request, Booking $booking, RoomReservation $roomReservation): RedirectResponse
	{
		return redirect()->back();
	}

	public function checkouts(Request $request, Booking $booking, Room $room): JsonResponse
	{
		return response()->json();
	}

	public function availability(Request $request, Booking $booking, Room $room): JsonResponse
	{
		return response()->json();
	}
}
