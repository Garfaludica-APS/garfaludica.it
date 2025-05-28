<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\LocalizeApp;
use App\Http\Middleware\VerifyBookingState;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

return Application::configure(basePath: \dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		commands: __DIR__ . '/../routes/console.php',
		health: '/up',
		then: function() {
			Route::middleware('web')
				->prefix('en')
				->name('en.')
				->group(base_path('routes/web-en.php'));
			Route::name('external.')
				->group(base_path('routes/external.php'));
			Route::name('en.external.')
				->group(base_path('routes/external-en.php'));
		},
	)
	->withMiddleware(function(Middleware $middleware) {
		$middleware->encryptCookies(except: [
			'locale',
		]);
		$middleware->alias([
			'localized' => LocalizeApp::class,
			'bookingStatus' => VerifyBookingState::class,
		]);
		$middleware->web(prepend: [
			LocalizeApp::class,
		]);
		$middleware->web(append: [
			HandleInertiaRequests::class,
		]);
		$middleware->replace(
			\Illuminate\Http\Middleware\TrustProxies::class,
			\Monicahq\Cloudflare\Http\Middleware\TrustProxies::class
		);
		$middleware->priority([
			\Illuminate\Session\Middleware\StartSession::class,
			LocalizeApp::class,
		]);
	})
	->withExceptions(function(Exceptions $exceptions) {
		$exceptions->respond(static function(JsonResponse|RedirectResponse|Response $response, \Throwable $exception, Request $request): JsonResponse|RedirectResponse|Response {
			if ($response->getStatusCode() < 400 || $response->getStatusCode() >= 600)
				return $response;
			if (!app()->environment(['local', 'testing']) && !\in_array($response->getStatusCode(), [419, 503])) {
				Inertia::share((new HandleInertiaRequests())->share($request)); /* see inertiajs/inertia-laravel/issues/176 */
				return Inertia::render('Error', ['status' => $response->getStatusCode()])
					->toResponse($request)
					->setStatusCode($response->getStatusCode());
			}
			if (!app()->environment(['local', 'testing']) && $response->getStatusCode() === 503) {
				Inertia::share((new HandleInertiaRequests())->share($request)); /* see inertiajs/inertia-laravel/issues/176 */
				return Inertia::render('Maintenance')
					->toResponse($request)
					->setStatusCode($response->getStatusCode());
			}
			if ($response->getStatusCode() === 419)
				return back()->with([
					'message', __('error.419.message'),
				]);
			return $response;
		});
	})
	->withSchedule(function(Schedule $schedule) {
		$schedule->call('telescope:prune --hours=72')->daily();
		$schedule->command('cloudflare:reload')->daily()->environments('production');
	})
	->create();
