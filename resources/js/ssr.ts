/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createSSRApp, type DefineComponent, h } from 'vue';
import { i18nVue } from 'laravel-vue-i18n';
import { LocalizedZiggyVue } from './helpers';

const appName = import.meta.env.VITE_APP_NAME || 'Garfaludica APS';

createServer((page) =>
	createInertiaApp({
		page,
		render: renderToString,
		title: (title) => title ? `${title} - ${appName}` : `${appName}`,
		resolve: (name) => resolvePageComponent(
			`./Pages/${name}.vue`,
			import.meta.glob<DefineComponent>('./Pages/**/*.vue')
		),
		setup({ App, props, plugin }) {
			return createSSRApp({ render: () => h(App, props) })
				.use(plugin)
				.use(LocalizedZiggyVue, {
					...page.props.ziggy,
					location: new URL(page.props.ziggy.location),
				})
				.use(i18nVue, {
					lang: page.props.app.locale,
					resolve: lang => {
						const langs = import.meta.glob('../../lang/*.json', { eager: true });
						return langs[`../../lang/${lang}.json`].default;
					},
				});
		},
	})
);
