/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

import { defineConfig } from "vite";
import * as path from "path";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";
import i18n from "laravel-vue-i18n/vite";
import Components from "unplugin-vue-components/vite";
import { HeadlessUiResolver } from "unplugin-vue-components/resolvers";
import {
	UnpluginVueComponentsResolver,
	UnpluginDirectivesResolver,
	UnpluginModulesResolver,
} from "maz-ui/resolvers";

export default defineConfig({
	plugins: [
		laravel({
			input: "resources/js/app.ts",
			ssr: "resources/js/ssr.ts",
			refresh: true,
		}),
		tailwindcss(),
		vue({
			template: {
				transformAssetUrls: {
					base: null,
					includeAbsolute: false,
				},
			},
		}),
		i18n(),
		Components({
			resolvers: [
				UnpluginVueComponentsResolver(),
				UnpluginDirectivesResolver(),
				UnpluginModulesResolver(),
				HeadlessUiResolver(),
			],
			dirs: ["resources/js/Components"],
			directoryAsNamespace: true,
			collapseSamePrefixes: true,
		}),
	],
	resolve: {
		alias: {
			"ziggy-js": path.resolve("vendor/tightenco/ziggy"),
			"inertia-modal": path.resolve(
				"vendor/emargareten/inertia-modal",
			),
		},
	},
});
