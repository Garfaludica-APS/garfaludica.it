<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function create(Request $request, Booking $booking): JsonResponse
	{
		return response()->json();
	}

	public function capture(Request $request, Booking $booking): JsonResponse
	{
		return response()->json();
	}
}
