<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotesController extends Controller
{
	public function store(Request $request, Booking $booking): RedirectResponse
	{
		return redirect()->route('gobcon.booking.billing.index');
	}

	public function update(Request $request, Booking $booking): RedirectResponse
	{
		return redirect()->back();
	}
}
