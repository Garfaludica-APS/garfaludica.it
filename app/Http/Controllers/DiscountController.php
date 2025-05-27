<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DiscountCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
	public function apply(Request $request, Booking $booking): RedirectResponse
	{
		$validated = $request->validate([
			'discount_code' => 'required|string|max:32',
		]);

		$discountCode = DiscountCode::firstWhere('key', $validated['discount_code']);

		if (!$discountCode)
			return redirect()->back()->withErrors(['discount_code' => 'gobcon.booking.invalid_discount_code']);
		$booking->discount_code = $discountCode;
		$booking->save();

		return redirect()->back();
	}
}
