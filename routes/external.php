<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use Illuminate\Support\Facades\Route;

Route::name('gmaps.')->domain('https://maps.app.goo.gl')->group(function() {
	Route::get('/2idX8ujXq7p7jAqTA')->name('operationalHQ');
	Route::get('/Mt2gA2nt1Au2kETS7')->name('registeredOffice');
});

Route::name('telegram.')->domain('https://t.me')->group(function() {
	Route::get('/associazionegarfaludica')->name('group');
	Route::get('/GarfaludicaAPSbot')->name('bot');
	Route::get('/Pillian')->name('president');
	Route::get('/SpeedJack')->name('secretary');
	Route::get('/Badpinger')->name('vicepresident');
	Route::get('/CannibalSmith')->name('cannibalsmith');
	Route::get('/Picarus')->name('picarus');
});

Route::name('facebook.')->domain('https://facebook.com')->group(function() {
	Route::get('/garfaludica')->name('page');
});

Route::name('instagram.')->domain('https://instagram.com')->group(function() {
	Route::get('/garfaludica')->name('page');
});

Route::name('discord.')->domain('https://discord.gg')->group(function() {
	Route::get('/vMUct2bxSe')->name('server');
});

Route::name('github.')->domain('https://github.com')->group(function() {
	Route::get('/Garfaludica-APS')->name('organization');
});

Route::name('MLPS.')->domain('https://servizi.lavoro.gov.it')->group(function() {
	Route::get('/runts')->name('runts');
});

Route::name('goblins.')->domain('https://www.goblins.net')->group(function() {
	Route::name('associations.')->prefix('affiliate')->group(function() {
		Route::get('/tana-dei-goblin-castelnuovo-di-garfagnana')->name('garfaludica');
	});
});

Route::name('federludo.')->domain('https://www.federludo.it')->group(function() {
	Route::name('associations.')->prefix('associazioni')->group(function() {
		Route::get('/garfaludica-aps')->name('garfaludica');
	});
});

Route::name('aics.')->domain('https://www.aics.it')->group(function() {
	Route::get('/')->name('home');
});

Route::name('paypal.objects.')->domain('https://www.paypalobjects.com')->group(function() {
	Route::get('/donate/sdk/donate-sdk.js')->name('donateSDK');
	Route::get('/it_IT/IT/i/btn/btn_donateCC_LG.gif')->name('donateButton');
});

Route::name('en.paypal.objects.')->domain('https://www.paypalobjects.com')->group(function() {
	Route::get('/en_US/i/btn/btn_donateCC_LG.gif')->name('donateButton');
});

Route::name('cloudflare.')->domain('https://www.cloudflare.com')->group(function() {
	Route::get('/privacypolicy')->name('privacyPolicy');
});
