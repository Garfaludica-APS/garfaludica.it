<!-- Copyright © 2025 - Garfaludica APS - MIT License -->
<!-- Contains code adapted from Tailwind UI - https://tailwindui.com/license -->

<script lang="ts">
	import BaseLayout from '@/Layouts/BaseLayout.vue';
	import AuthLayout from '@/Layouts/AuthLayout.vue';

	export default {
		layout: (h, page) =>
			h(BaseLayout, {
			},
			() =>
				h(AuthLayout, {
				},
				() => page)
			),
	};
</script>

<script setup lang="ts">
	import { Head } from '@inertiajs/vue3';

	defineProps({
		logoUrl: String,
	});
</script>

<template>
	<Head>
		<title>{{ $t('auth.login_form.page_title') }}</title>
		<meta head-key="description" name="description" :content="$t('auth.login_form.description')">
		<meta head-key="keywords" name="keywords" :content="$t('auth.login_form.keywords')">
		<meta head-key="color-scheme" name="color-scheme" content="dark light">
		<meta head-key="theme-color" name="theme-color" content="#101828">
		<link rel="canonical" :href="route('auth')" />
		<link rel="alternate" hreflang="it" :href="ziggy('auth')" />
		<link rel="alternate" hreflang="en" :href="ziggy('en.auth')" />
		<link rel="x-default" :href="ziggy('en.auth')" />
	</Head>
	<div class="flex min-h-full flex-1 flex-col justify-center py-12 sm:px-6 lg:px-8">
		<header class="sm:mx-auto sm:w-full sm:max-w-md">
			<img class="mx-auto h-10 w-auto" :src="logoUrl" :alt="$t('Logo Garfaludica APS')" />
			<h2 class="mt-6 text-center text-2xl/9 font-bold tracking-tight text-foreground">{{ $t('auth.login_form.title') }}</h2>
		</header>

		<main class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
			<div class="bg-card-background px-6 py-12 shadow-sm sm:rounded-lg sm:px-12">
				<form class="space-y-6" action="#" method="POST">
					<div>
						<label for="email" class="block text-sm/6 font-medium text-foreground">{{ $t('auth.login_form.username_email') }}</label>
						<div class="mt-2">
							<input type="text" name="username" id="username" autocomplete="username email" required class="block w-full rounded-md bg-input-background px-3 py-1.5 text-base text-foreground outline-1 -outline-offset-1 outline-input-outline placeholder:text-placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-input-outline-focus sm:text-sm/6" />
						</div>
					</div>

					<div>
						<label for="password" class="block text-sm/6 font-medium text-foreground">{{ $t('auth.login_form.password') }}</label>
						<div class="mt-2">
							<input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-input-background px-3 py-1.5 text-base text-foreground outline-1 -outline-offset-1 outline-input-outline placeholder:text-placeholder focus:outline-2 focus:-outline-offset-2 focus:outline-input-outline-focus sm:text-sm/6" />
						</div>
					</div>

					<div class="flex items-center justify-between">
						<div class="flex gap-3">
							<div class="flex h-6 shrink-0 items-center">
								<div class="group grid size-4 grid-cols-1">
									<input id="remember-me" name="remember-me" type="checkbox" class="col-start-1 row-start-1 appearance-none accent-checkbox-checked rounded-sm border border-input-outline bg-checkbox-background checked:border-checkbox-checked checked:bg-checkbox-checked indeterminate:border-checkbox-checked indeterminate:bg-checkbox-checked focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-input-outline-focus disabled:border-input-outline disabled:bg-checkbox-disabled disabled:checked:bg-checkbox-disabled forced-colors:appearance-auto" />
									<svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
										<path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
										<path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									</svg>
								</div>
							</div>
							<label for="remember-me" class="block text-sm/6 text-foreground">{{ $t('auth.login_form.remember') }}</label>
						</div>

						<div class="text-sm/6">
							<a href="#" class="font-semibold text-link hover:text-link-hover">{{ $t('auth.login_form.forgot') }}</a>
						</div>
					</div>

					<div>
						<button type="submit" class="flex w-full justify-center rounded-md bg-primary-btn px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-primary-btn-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-btn disabled:bg-primary-btn-disabled" disabled>{{ $t('auth.login_form.sign_in') }}</button>
					</div>
				</form>
			</div>

			<p class="mt-10 text-center text-sm/6">
				<a :href="route('home')" class="font-semibold text-link hover:text-link-hover">{{ $t('auth.login_form.back') }}</a>
			</p>
		</main>
	</div>
</template>
