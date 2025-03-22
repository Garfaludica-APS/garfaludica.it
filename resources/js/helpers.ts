/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

import { route as zroute } from 'ziggy-js';
import { loadLanguageAsync, getActiveLanguage } from 'laravel-vue-i18n';
import Router from 'ziggy-js/src/js/Router.js';
import { router } from '@inertiajs/vue3';

export class LocalizedRouter extends Router {

	constructor(name, params, absolute = true, config) {
		super(name, params, absolute, config);
	}

	current(name, params) {
		if (!name) {
			const cur = super.current(name, params);
			if (cur && cur.startsWith('en.'))
				return cur.substring(3);
			return cur;
		}
		return super.current(name, params) || super.current('en.' + name, params);
	}

	currentExact(name, params) {
		return super.current(name, params);
	}
}

export function route(name, params, absolute, config) {
	if (!import.meta.env.SSR)
		delete config.location;
	if (!name)
		return new LocalizedRouter(name, params, absolute, config);
	if (zroute(undefined, undefined, absolute, config).has(name)) {
		if (name.startsWith('en.'))
			return (new LocalizedRouter(name, params, absolute, config)).toString();
		if (getActiveLanguage() == 'en' && zroute(undefined, undefined, absolute, config).has('en.' + name))
			return (new LocalizedRouter('en.' + name, params, absolute, config)).toString();
		return (new LocalizedRouter(name, params, absolute, config)).toString();
	}
	return (new LocalizedRouter(name, params, absolute, config)).toString();
}

export const LocalizedZiggyVue = {
	install(app: any, options?: Config): void {
		const r = (name, params, absolute, config = options) =>
			route(name, params, absolute, config);
		const z = (name, params, absolute, config = options) =>
			zroute(name, params, absolute, config);
		const l = (lang) =>
			loadLanguage(lang, options);
		const s = () =>
			switchLanguage(options);
		app.config.globalProperties.route = r;
		app.config.globalProperties.ziggy = z;
		app.config.globalProperties.loadLanguage = l;
		app.config.globalProperties.switchLanguage = s;
		app.config.globalProperties.getActiveLanguage = getActiveLanguage;
		app.provide('route', r);
		app.provide('ziggy', z);
		app.provide('loadLanguage', l);
		app.provide('switchLanguage', s);
		app.provide('getActiveLanguage', getActiveLanguage);
	},
};

export function loadLanguage(lang: string, options?: Config) {
	loadLanguageAsync(lang).then(() => {
		const prefix = lang == 'en' ? 'en.' : '';
		const newRoute = prefix + route(undefined, undefined, false, options).current();
		const newUrl = route(newRoute, undefined, false, options);
		router.replace({
			url: newUrl,
			preserveScroll: true,
		});
	});
	if (import.meta.env.SSR)
		return;
	const date = new Date();
	date.setTime(date.getTime() + 365 * 24 * 60 * 60 * 1000);
	const expires = date.toUTCString();
	const domain = window.location.hostname;
	document.cookie = `locale=${lang};expires=${expires};path=/;SameSite=Lax;domain=${domain};secure`;
}

export function switchLanguage(options?: Config) {
	loadLanguage(getActiveLanguage() == 'en' ? 'it' : 'en', options);
}
