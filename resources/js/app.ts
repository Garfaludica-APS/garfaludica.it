/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createSSRApp, type DefineComponent, h } from 'vue';
import { i18nVue } from 'laravel-vue-i18n';
import { LocalizedZiggyVue } from './helpers';

const appName = import.meta.env.VITE_APP_NAME || 'Garfaludica APS';

createInertiaApp({
	title: (title) => title ? `${title} - ${appName}` : `${appName}`,
	resolve: (name) => resolvePageComponent(
		`./Pages/${name}.vue`,
		import.meta.glob<DefineComponent>('./Pages/**/*.vue')
	),
	setup({ el, App, props, plugin }) {
		const app = createSSRApp({
			render: () => h(App, props),
		})
		.use(plugin)
		.use(LocalizedZiggyVue, {
			...props.initialPage.props.ziggy,
			location: new URL(props.initialPage.props.ziggy.location),
		})
		.use(i18nVue, {
			resolve: async lang => {
				const langs = import.meta.glob('../../lang/*.json');
				return await langs[`../../lang/${lang}.json`]();
			},
			onLoad: () => {
				if (el && el.__vue_app__)
					return;
				app.mount(el);
			}
		});
		return app;
	},
	progress: {
		color: '#4F46E5',
	},
});
