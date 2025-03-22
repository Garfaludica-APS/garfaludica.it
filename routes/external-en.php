<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use Illuminate\Support\Facades\Route;

Route::name('paypal.objects.')->domain('https://www.paypalobjects.com')->group(function() {
	Route::get('/en_US/IT/i/btn/btn_donateCC_LG.gif')->name('donateButton');
});
