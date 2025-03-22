/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.ts',
		'./resources/js/**/*.vue',
	],
	plugins: [],
};
