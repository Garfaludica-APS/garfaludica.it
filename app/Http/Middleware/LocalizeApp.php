<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocalizeApp
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Closure(Request): (Response) $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$locale = $request->cookie('locale') ?? $request->getPreferredLanguage(['it', 'en'] ?? App::getLocale());

		if ($request->isMethod('GET') || $request->isMethod('HEAD')) {
			$routeName = $request->route()->getName();
			if (Str::startsWith($routeName, 'en.')) {
				$locale = 'en';
			} elseif (Route::has('en.' . $routeName)) {
				try {
					$prevRouteName = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();
					if ($prevRouteName === $routeName || $prevRouteName === 'en.' . $routeName)
						$locale = Config::get('app.locale', 'it');
				} catch (NotFoundHttpException $e) {
				}
			}
		}

		App::setLocale($locale);
		$locale = App::currentLocale();

		if (!$request->hasCookie('locale') || $request->cookie('locale') !== $locale)
			Cookie::queue('locale', $locale, 60 * 24 * 365, null, null, null, false);

		if ($locale === 'en' && ($request->isMethod('GET') || $request->isMethod('HEAD'))
			&& !Str::startsWith($routeName, 'en.')
			&& Route::has('en.' . $routeName))
				return redirect()->route('en.' . $routeName, $request->route()->parameters());
		return $next($request);
	}
}
