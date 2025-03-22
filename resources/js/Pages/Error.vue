<!-- Copyright © 2025 - Garfaludica APS - MIT License -->
<!-- Contains code adapted from Tailwind UI - https://tailwindui.com/license -->

<script setup lang="ts">
	import { computed } from 'vue';
	import { Head, Link } from '@inertiajs/vue3';

	const props = defineProps({
		status: Number,
	});

	const statusCode = computed(() => {
		if ([400, 401, 402, 403, 404, 405, 410, 419, 429, 500, 501, 503].includes(props.status))
			return props.status.toString();
		else if (props.status < 500 && props.status >= 400)
			return '4xx';
		else if (props.status < 600 && props.status >= 500)
			return '5xx';
		else
			return 'xxx';
	});
</script>
<template>
	<Head>
		<title>{{ $t(`error.${statusCode}.title`) }}</title>
		<meta head-key="description" name="description" :content="$t(`error.${statusCode}.message`)">
		<meta head-key="robots" name="robots" content="noindex, nofollow">
		<meta head-key="color-scheme" name="color-scheme" content="light">
		<meta head-key="theme-color" name="theme-color" content="#4f39f6">
	</Head>
	<main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
		<div class="text-center">
			<p class="text-base font-semibold text-indigo-600">{{ status }}</p>
			<h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">{{ $t(`error.${statusCode}.title`) }}</h1>
			<p class="mt-6 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">{{ $t(`error.${statusCode}.message`) }}</p>
			<div class="mt-10 flex items-center justify-center gap-x-6">
				<Link :href="route('home')" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ $t('error.back_home') }}</Link>
				<Link href="#" class="text-sm font-semibold text-gray-900">{{ $t('error.contact_support') }} <span aria-hidden="true">&rarr;</span></Link>
			</div>
		</div>
	</main>
</template>

