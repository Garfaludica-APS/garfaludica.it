<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Http\Controllers\GobCon;
use App\Http\Controllers\WebsiteUnderConstruction;
use Illuminate\Support\Facades\Route;

Route::domain('auth.' . env('APP_DOMAIN'))->group(function() {
	Route::get('/', fn() => inertia('Auth/LoginForm', [
		'logoUrl' => asset('storage/images/hotlink-ok/garfaludica-logo-dice.png'),
	]))->name('auth');
});

Route::domain('gobcon.' . env('APP_DOMAIN'))->name('gobcon.')->group(function() {
	Route::post('/notifyme', [GobCon::class, 'notifyMe'])->name('notifyMe');
	Route::get('/', [GobCon::class , 'index'])->name('home');
});

Route::domain('www.' . env('APP_DOMAIN'))->group(function() {
	Route::get('/', WebsiteUnderConstruction::class)->name('home');
	Route::get('/license', fn() => inertia('License'))->name('license');
});

