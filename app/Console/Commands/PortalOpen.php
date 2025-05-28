<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Console\Commands;

use App\Mail\PortalOpen as MailPortalOpen;
use App\Models\Booking;
use App\Models\NotifyEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PortalOpen extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'notify:portalopen';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$emails = NotifyEmail::all();
		foreach ($emails as $email) {
			$booking = Booking::create([
				'email' => $email->email,
				'expires_at' => now()->addMonth(),
			]);
			$this->info("Sending portal open notification to: {$email->email}");
			Mail::to($email->email)->queue(new MailPortalOpen($booking));
		}
	}
}
