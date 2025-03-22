/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

import { Config } from 'ziggy-js';

export interface User {
	id: number;
	name: string;
	email: string;
	email_verified_at?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
	auth: {
		user: User;
	};
	ziggy: Config & { location: string };
};

export const LocalizedZiggyVue: {
	install(app: any, options?: Config): void;
};
