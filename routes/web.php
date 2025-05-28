<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Http\Controllers\BookingController;
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
	Route::get('/', [GobCon::class, 'index'])->name('home');

	Route::prefix('booking')->name('booking.')->group(function() {
		Route::post('/start', [BookingController::class, 'start'])->name('start');

		Route::get('/{booking}', [BookingController::class, 'index'])
			->name('index');

		Route::get('/{booking}/rooms', [BookingController::class, 'rooms'])
			->name('rooms');
		Route::put('/{booking}/rooms', [BookingController::class, 'addRoom'])
			->name('rooms.store');
		Route::delete('/{booking}/rooms/{reservation}', [BookingController::class, 'deleteRoom'])
			->name('rooms.delete');
		Route::post('/{booking}/rooms/{room}/checkouts', [BookingController::class, 'availableCheckouts'])
			->name('room.available-checkouts');
		Route::post('/{booking}/rooms/{room}/availability', [BookingController::class, 'maxPeople'])
			->name('room.max-people');

		Route::get('/{booking}/meals', [BookingController::class, 'meals'])
			->name('meals');
		Route::patch('/{booking}/meals', [BookingController::class, 'editMeals'])
			->name('meals.edit');

		Route::post('/{booking}/notes', [BookingController::class, 'storeNotes'])
			->name('notes.store');
		Route::patch('/{booking}/notes', [BookingController::class, 'addNotes'])
			->name('add-notes');

		Route::get('/{booking}/billing', [BookingController::class, 'billing'])
			->name('billing');
		Route::post('/{booking}/billing', [BookingController::class, 'storeBilling'])
			->name('billing.store');
		Route::patch('/{booking}/billing', [BookingController::class, 'updateBilling'])
			->name('update-billing');

		Route::get('/{booking}/summary', [BookingController::class, 'summary'])
			->name('summary');

		Route::post('/{booking}/discount', [BookingController::class, 'addDiscount'])
			->name('discount.add');

		Route::delete('/{booking}/reset', [BookingController::class, 'resetOrder'])
			->name('reset');
		Route::post('/{booking}/terminate', [BookingController::class, 'terminate'])
			->name('terminate');

		Route::post('/{booking}/payment', [BookingController::class, 'createOrder'])
			->name('createOrder');
		Route::post('/{booking}/payment/{orderId}/capture', [BookingController::class, 'captureOrder'])
			->name('captureOrder');

		Route::get('/{booking}/success', [BookingController::class, 'successOrder'])
			->name('success');
		Route::get('/{booking}/aborted', [BookingController::class, 'abortOrder'])
			->name('abort');

		Route::get('/{booking}/manage', [BookingController::class, 'manageBooking'])
			->name('manage');
		Route::post('/{booking}/refund', [BookingController::class, 'refundBooking'])
			->name('refund');
	});
});

Route::domain('www.' . env('APP_DOMAIN'))->group(function() {
	Route::get('/', WebsiteUnderConstruction::class)->name('home');
	Route::get('/license', fn() => inertia('License'))->name('license');
});
