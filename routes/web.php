<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Http\Controllers\BillingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\GobCon;
use App\Http\Controllers\MealController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\WebsiteUnderConstruction;
use Illuminate\Support\Facades\Route;

Route::domain('auth.' . env('APP_DOMAIN'))->group(function() {
	Route::get('/', fn() => inertia('Auth/LoginForm', [
		'logoUrl' => asset('storage/images/hotlink-ok/garfaludica-logo-dice.png'),
	]))->name('auth');
});

Route::domain('gobcon.' . env('APP_DOMAIN'))->name('gobcon.')->group(function() {
	Route::post('/notifyme', [GobCon::class, 'notifyMe'])->name('notifyMe');
	Route::get('/', [GobCon::class, 'index'])->name('home');

	Route::prefix('booking')->name('booking.')->group(function() {
		Route::post('/start', [BookingController::class, 'start'])->name('start');

		Route::get('/{booking}', [BookingController::class, 'index'])
			->middleware(['signed', 'bookingStatus:start,rooms,meals,billing,summary'])
			->name('index');

		Route::get('/{booking}/rooms', [RoomController::class, 'index'])
			->middleware('bookingStatus:rooms,meals')
			->name('rooms.index');
		Route::post('/{booking}/rooms', [RoomController::class, 'store'])
			->middleware('bookingStatus:rooms')
			->name('rooms.store');
		Route::delete('/{booking}/rooms/{roomReservation}', [RoomController::class, 'destroy'])
			->middleware('bookingStatus:rooms')
			->name('rooms.destroy');
		Route::get('/{booking}/rooms/{room}/checkouts', [RoomController::class, 'checkouts'])
			->middleware('bookingStatus:rooms')
			->name('rooms.checkouts');
		Route::get('/{booking}/rooms/{room}/availability', [RoomController::class, 'availability'])
			->middleware('bookingStatus:rooms')
			->name('rooms.availability');

		Route::get('/{booking}/meals', [MealController::class, 'index'])
			->middleware('bookingStatus:rooms,meals,billing')
			->name('meals.index');
		Route::put('/{booking}/meals', [MealController::class, 'sync'])
			->middleware('bookingStatus:meals')
			->name('meals.sync');

		Route::post('/{booking}/notes', [NotesController::class, 'store'])
			->middleware('bookingStatus:meals')
			->name('notes.store');
		Route::patch('/{booking}/notes', [NotesController::class, 'update'])
			->middleware('bookingStatus:completed')
			->name('notes.update');

		Route::get('/{booking}/billing', [BillingController::class, 'index'])
			->middleware('bookingStatus:billing,summary')
			->name('billing.index');
		Route::post('/{booking}/billing', [BillingController::class, 'store'])
			->middleware('bookingStatus:billing')
			->name('billing.store');
		Route::patch('/{booking}/billing', [BillingController::class, 'update'])
			->middleware('bookingStatus:completed')
			->name('billing.update');

		Route::get('/{booking}/summary', [BookingController::class, 'summary'])
			->middleware('bookingStatus:summary,payment')
			->name('summary');

		Route::post('/{booking}/discount', [DiscountController::class, 'apply'])
			->middleware('bookingStatus:billing,summary')
			->name('discount.apply');

		Route::delete('/{booking}/reset', [BookingController::class, 'reset'])
			->middleware('bookingStatus:rooms,meals,billing')
			->name('reset');
		Route::delete('/{booking}/terminate', [BookingController::class, 'terminate'])
			->middleware('bookingStatus:rooms,meals,billing,summary,payment')
			->name('terminate');

		Route::post('/{booking}/payment', [PaymentController::class, 'create'])
			->middleware('bookingStatus:summary')
			->name('payment.create');
		Route::get('/{booking}/payment', [PaymentController::class, 'capture'])
			->middleware('bookingStatus:payment')
			->name('payment.capture');

		Route::get('/{booking}/success', [BookingController::class, 'success'])
			->middleware('bookingStatus:completed')
			->name('success');
		Route::get('/{booking}/aborted', [BookingController::class, 'aborted'])
			->middleware('bookingStatus:cancelled,payment,failed')
			->name('aborted');

		Route::get('/{booking}/manage', [BookingController::class, 'manage'])
			->middleware(['signed', 'bookingStatus:completed'])
			->name('manage');
		Route::post('/{booking}/refund', [BookingController::class, 'refund'])
			->middleware('bookingStatus:completed')
			->name('refund');
	});
});

Route::domain('www.' . env('APP_DOMAIN'))->group(function() {
	Route::get('/', WebsiteUnderConstruction::class)->name('home');
	Route::get('/license', fn() => inertia('License'))->name('license');
});
