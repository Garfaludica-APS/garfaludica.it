/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import { route as localizedRoute, loadLanguage as loadLanguageFn, switchLanguage as switchLanguageFn } from '../helpers';
import { PageProps as AppPageProps } from './';

declare global {
	interface Window {
		axios: AxiosInstance;
	}

	var route: typeof localizedRoute;
	var loadLanguage: typeof loadLanguageFn;
	var switchLanguage: typeof switchLanguageFn;

	declare module 'vue' {
		interface ComponentCustomProperties {
			route: typeof localizedRoute;
			loadLanguage: typeof loadLanguageFn;
			switchLanguage: typeof switchLanguageFn;
		}
	}

	declare module '@inertuajs/core' {
		interface PageProps extends InertiaPageProps, AppPageProps {}
	}
}
