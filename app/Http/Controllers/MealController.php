<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MealController extends Controller
{
	public function index(Request $request, Booking $booking): Response
	{
		return Inertia::render('GobCon/Booking/Meals');
	}

	public function sync(Request $request, Booking $booking): RedirectResponse
	{
		return redirect()->back();
	}
}
