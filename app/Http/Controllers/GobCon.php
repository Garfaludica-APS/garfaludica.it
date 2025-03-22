<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use App\Models\NotifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class GobCon extends Controller
{
	public function index(Request $request): Response
	{
		return inertia('GobCon/Home', [
			'appMark' => asset('storage/images/hotlink-ok/mark.png'),
			'photo1' => asset('storage/images/gobcon/photo-1.jpg'),
			'photo2' => asset('storage/images/gobcon/photo-2.jpg'),
			'photo3' => asset('storage/images/gobcon/photo-3.jpg'),
			'photo4' => asset('storage/images/gobcon/photo-4.jpg'),
			'tdgLogo' => asset('storage/images/gobcon/tdg-logo.png'),
			'heroImage' => asset('storage/images/gobcon/hero.jpg'),
			'heroVideo' => asset('storage/videos/hero.mp4'),
			'appScreenshot' => asset('storage/images/gobcon/telegram.jpg'),
		]);
	}

	public function notifyMe(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'email' => 'required|max:254|email:strict,dns,spoof|unique:notify_emails',
		]);

		$notifyEmail = NotifyEmail::create([...$validated]);

		return redirect()->back();
	}
}
