<!-- Copyright © 2025 - Garfaludica APS - MIT License -->

<script lang="ts">
	import BaseLayout from '@/Layouts/BaseLayout.vue';
	import PubLayout from '@/Layouts/PubLayout.vue';

	export default {
		layout: (h, page) =>
			h(BaseLayout, {
			},
			() =>
				h(PubLayout, {
				},
				() => page)
			),
	};
</script>

<script setup lang="ts">
	import { computed, inject, onMounted, onUnmounted, ref } from 'vue';
	import { Head, Link } from '@inertiajs/vue3';
	import { trans } from 'laravel-vue-i18n';
	import { MapPinIcon } from '@heroicons/vue/24/solid';
	import { LockClosedIcon, GlobeAltIcon } from '@heroicons/vue/24/outline';
	import dayjs from 'dayjs';
	import localizedFormat from 'dayjs/plugin/localizedFormat';
	import 'dayjs/locale/it';

	const getActiveLanguage = inject('getActiveLanguage');
	const loadLanguage = inject('loadLanguage');
	const route = inject('route');

	dayjs.extend(localizedFormat);

	const props = defineProps({
		certifiedEmailAddress: String,
		councillorsInfo: Array,
		documents: Array,
		donateButtonId: String,
		emailAddress: String,
		iban: String,
		licenseUrl: String,
		logoAicsUrl: String,
		logoFederludoUrl: String,
		logoTdgUrl: String,
		logoUrl: String,
		officeAddress: String,
		presidentInfo: Object,
		privacyEmailAddress: String,
		runtsArchiveNumber: [String, Number],
		runtsDate: String,
		secretaryInfo: Object,
		slideshowImages: Array,
		taxIdCode: String,
		telephoneNumber: String,
		vicePresidentInfo: Object,
	});

	const runtsDateStr = computed(() => dayjs(props.runtsDate, 'YYYY-MM-DD').locale(getActiveLanguage()).format('LL'));

	const bgImageAbove = ref(props.slideshowImages[0]);
	const bgImageBelow = ref(props.slideshowImages[1]);
	const bgImageAboveOpacity = ref(1);
	const bgImageAboveStyle = computed(() => `background-image: url(${bgImageAbove.value}); opacity: ${bgImageAboveOpacity.value}`);
	const bgImageBelowStyle = computed(() => `background-image: url(${bgImageBelow.value})`);

	let slideIndex = 1;
	let showSlidesTimerId;
	let preloadNextSlideTimerId;

	const preloadNextSlide = () => {
		if (slideIndex % 2 === 0)
			bgImageAbove.value = props.slideshowImages[slideIndex];
		else
			bgImageBelow.value = props.slideshowImages[slideIndex];
		showSlidesTimerId = setTimeout(showSlides, 5000);
	}

	const showSlides = () => {
		slideIndex++;
		if (slideIndex >= props.slideshowImages.length)
			slideIndex = 0;
		bgImageAboveOpacity.value = slideIndex % 2;
		preloadNextSlideTimerId = setTimeout(preloadNextSlide, 2500);
	}

	function loadPaypalButton()
	{
		PayPal.Donation.Button({
			env: 'production',
			hosted_button_id: props.donateButtonId,
			image: {
				src: route('external.paypal.objects.donateButton'),
				alt: trans('paypal.button.alt'),
				title: trans('paypal.button.title'),
			},
		}).render('#donate-button');
	}

	const toastVisible = ref(false);
	const toastOpacityStyle = computed(() => `opacity: ${toastVisible.value ? 1 : 0}`);
	const toastText = ref('');
	let toastTimerId;

	const showToast = (text) => {
		if (toastVisible.value) {
			clearTimeout(toastTimerId);
			toastTimerId = undefined;
		}
		toastText.value = text;
		toastVisible.value = true;
		toastTimerId = setTimeout(() => {
			toastVisible.value = false;
			toastTimerId = undefined;
		}, 7000);
	}

	function copyToClipboard(text)
	{
		navigator.clipboard.writeText(text).then(() => {
			showToast(trans('wuc.copied_to_clipboard'))
		});
	}

	const currentLang = ref(getActiveLanguage());

	function changeLanguage(lang)
	{
		if (lang === getActiveLanguage())
			return;
		loadLanguage(lang);
	}

	onMounted(() => {
		if (typeof PayPal === 'undefined') {
			const script = document.createElement('script');
			script.src = route('external.paypal.objects.donateSDK');
			script.charset = 'UTF-8';
			document.head.appendChild(script);
			script.onload = loadPaypalButton;
		} else {
			loadPaypalButton();
		}
		showSlidesTimerId = setTimeout(showSlides, 7500);
	});

	onUnmounted(() => {
		clearTimeout(showSlidesTimerId);
		clearTimeout(preloadNextSlideTimerId);
		if (toastTimerId)
			clearTimeout(toastTimerId);
	});
</script>

<template>
	<Head>
		<title>{{ $t('wuc.title') }}</title>
		<meta head-key="description" name="description" :content="$t('wuc.meta.description')">
		<meta head-key="keywords" name="keywords" :content="$t('wuc.meta.keywords')">
		<meta head-key="color-scheme" name="color-scheme" content="dark">
		<meta head-key="theme-color" name="theme-color" content="#101828">
		<link rel="canonical" :href="route('home')" />
		<link rel="alternate" hreflang="it" :href="ziggy('home')" />
		<link rel="alternate" hreflang="en" :href="ziggy('en.home')" />
		<link rel="x-default" :href="ziggy('en.home')" />
	</Head>
	<div :style="bgImageAboveStyle" class="fixed top-0 right-0 bottom-0 left-0 overflow-auto z-2 bg-cover bg-no-repeat bg-center bg-fixed transition-opacity duration-2000 ease-in-out" id="abovebg"></div>
	<div :style="bgImageBelowStyle" class="fixed top-0 right-0 bottom-0 left-0 overflow-auto z-1 bg-cover bg-no-repeat bg-center bg-fixed transition-opacity duration-2000 ease-in-out" id="belowbg"></div>
	<header class="block w-full mx-auto z-15">
		<nav class="relative flex flex-wrap items-center justify-between max-w-7xl py-6 mx-auto">
			<Link :href="route('home')">
				<img class="inline-block" :src="logoUrl" width="408.1" height="100" :alt="$t('Logo Garfaludica APS')">
			</Link>
			<div class="*:inline-block *:text-center *:px-5 *:text-lg *:font-bold *:hover:underline">
				<GlobeAltIcon class="size-14 inline-block -mr-12 -mt-1" />
				<select class="mr-4 *:text-lg *:font-bold *:hover:underline" v-model="currentLang" @change="changeLanguage($event.target.value)">
					<option value="it">{{ $t('ITA') }}</option>
					<option value="en">{{ $t('ENG') }}</option>
				</select>
				<!--sse-->
				<a class="border-r border-white border-solid" rel="noopener" :href="`tel:${telephoneNumber}`" target="_blank">
					{{ $t(telephoneNumber) }}
				</a>
				<a rel="noopener" :href="`mailto:${emailAddress}`" target="_blank">
					{{ $t(emailAddress) }}
				</a>
				<!--/sse-->
			</div>
			<!--sse-->
			<a class="fixed top-4 right-4 text-sm hover:underline text-slate-300" :href="route('auth')">
				<LockClosedIcon class="size-4 inline-block mr-1 relative -top-[2px]" />{{ $t('wuc.admin_panel') }}
			</a>
			<!--/sse-->
		</nav>
	</header>
	<main class="flex flex-wrap items-center justify-center text-center m-auto max-w-7xl w-full z-10 bg-neutral-950/60 ring-[1000vh] ring-neutral-950/60 *:inline-block *:max-w-2xl *:m-auto">
		<section>
			<h1 class="inline-block text-7xl font-bold mb-8 mx-auto">{{ $t('wuc.title') }}</h1>
			<p class="max-w-md text-lg mb-20 mx-auto" v-html="$t('wuc.description')"></p>
			<a class="mx-auto flex items-center justify-between w-xs h-13 border-2 border-solid border-red-500 text-red-500 rounded-3xl my-3 font-bold bg-neutral-950/40 hover:scale-102 hover:text-white hover:border-white hover:bg-red-500 transition-all duration-350 ease-in-out after:content-['']" rel="external noopener" :href="route('external.gmaps.operationalHQ')" target="_blank">
				<MapPinIcon class="size-6 mr-2 justify-self-start pl-3 scale-225" />
				<span class="-ml-3">{{ $t('wuc.buttons.location') }}</span>
			</a>
			<p class="max-w-md text-xs mx-auto *:hover:underline" v-html="$t('wuc.activity_details', { url: route('external.telegram.group') })"></p>
		</section>
		<!--sse-->
		<section class="max-w-xs">
			<h2 class="text-4xl font-bold mb-8 max-[938px]:mt-8">{{ $t('wuc.social_buttons_title') }}</h2>
			<nav>
				<a class="group mx-auto flex items-center justify-between w-xs h-13 border-2 border-solid border-sky-600 text-sky-600 rounded-3xl my-3 font-bold bg-neutral-950/40 hover:scale-102 hover:text-white hover:border-white hover:bg-sky-600 transition-all duration-350 ease-in-out animate-lighten-blink hover:[animation-play-state:paused] after:content-['']" rel="external noopener" :href="route('external.telegram.group')" target="_blank">
					<svg class="justify-self-start pl-3 scale-225 size-6 mr-2 fill-sky-600 group-hover:fill-white transition-colors duration-350 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z"/></svg>
					<span class="-ml-3">{{ $t('wuc.buttons.telegram') }}</span>
				</a>
				<a class="group mx-auto flex items-center justify-between w-xs h-13 border-2 border-solid border-indigo-600 text-indigo-600 rounded-3xl my-3 font-bold bg-neutral-950/40 hover:scale-102 hover:text-white hover:border-white hover:bg-indigo-600 transition-all duration-350 ease-in-out after:content-['']" rel="external noopener" :href="route('external.facebook.page')" target="_blank">
					<svg class="justify-self-start pl-3 scale-225 size-6 mr-2 fill-indigo-600 group-hover:fill-white transition-colors duration-350 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg>
					<span>{{ $t('wuc.buttons.facebook') }}</span>
				</a>
				<a class="group mx-auto flex items-center justify-between w-xs h-13 border-2 border-solid border-pink-600 text-pink-600 rounded-3xl my-3 font-bold bg-neutral-950/40 hover:scale-102 hover:text-white hover:border-white hover:bg-pink-600 transition-all duration-350 ease-in-out after:content-['']" rel="external noopener" :href="route('external.instagram.page')" target="_blank">
					<svg class="justify-self-start pl-3 scale-225 size-6 mr-2 fill-pink-600 group-hover:fill-white transition-colors duration 350 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
					<span>{{ $t('wuc.buttons.instagram') }}</span>
				</a>
				<a class="group mx-auto flex items-center justify-between w-xs h-13 border-2 border-solid border-indigo-500 text-indigo-500 rounded-3xl my-3 font-bold bg-neutral-950/40 hover:scale-102 hover:text-white hover:border-white hover:bg-indigo-500 transition-all duration-350 ease-in-out after:content-['']" rel="external noopener" :href="route('external.discord.server')" target="_blank">
					<svg class="justify-self-start pl-3 scale-225 size-6 mr-2 fill-indigo-500 group-hover:fill-white transition-colors duration 350 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M524.5 69.8a1.5 1.5 0 0 0 -.8-.7A485.1 485.1 0 0 0 404.1 32a1.8 1.8 0 0 0 -1.9 .9 337.5 337.5 0 0 0 -14.9 30.6 447.8 447.8 0 0 0 -134.4 0 309.5 309.5 0 0 0 -15.1-30.6 1.9 1.9 0 0 0 -1.9-.9A483.7 483.7 0 0 0 116.1 69.1a1.7 1.7 0 0 0 -.8 .7C39.1 183.7 18.2 294.7 28.4 404.4a2 2 0 0 0 .8 1.4A487.7 487.7 0 0 0 176 479.9a1.9 1.9 0 0 0 2.1-.7A348.2 348.2 0 0 0 208.1 430.4a1.9 1.9 0 0 0 -1-2.6 321.2 321.2 0 0 1 -45.9-21.9 1.9 1.9 0 0 1 -.2-3.1c3.1-2.3 6.2-4.7 9.1-7.1a1.8 1.8 0 0 1 1.9-.3c96.2 43.9 200.4 43.9 295.5 0a1.8 1.8 0 0 1 1.9 .2c2.9 2.4 6 4.9 9.1 7.2a1.9 1.9 0 0 1 -.2 3.1 301.4 301.4 0 0 1 -45.9 21.8 1.9 1.9 0 0 0 -1 2.6 391.1 391.1 0 0 0 30 48.8 1.9 1.9 0 0 0 2.1 .7A486 486 0 0 0 610.7 405.7a1.9 1.9 0 0 0 .8-1.4C623.7 277.6 590.9 167.5 524.5 69.8zM222.5 337.6c-29 0-52.8-26.6-52.8-59.2S193.1 219.1 222.5 219.1c29.7 0 53.3 26.8 52.8 59.2C275.3 311 251.9 337.6 222.5 337.6zm195.4 0c-29 0-52.8-26.6-52.8-59.2S388.4 219.1 417.9 219.1c29.7 0 53.3 26.8 52.8 59.2C470.7 311 447.5 337.6 417.9 337.6z"/></svg>
					<span>{{ $t('wuc.buttons.discord') }}</span>
				</a>
				<a class="group mx-auto flex items-center justify-between w-xs h-13 border-2 border-solid border-zinc-500 text-zinc-500 rounded-3xl my-3 font-bold bg-neutral-950/40 hover:scale-102 hover:text-white hover:border-white hover:bg-zinc-500 transition-all duration-350 ease-in-out after:content-['']" rel="external noopener" :href="route('external.github.organization')" target="_blank">
					<svg class="justify-self-start pl-3 scale-225 size-6 mr-2 fill-zinc-500 group-hover:fill-white transition-colors duration 350 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3 .3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5 .3-6.2 2.3zm44.2-1.7c-2.9 .7-4.9 2.6-4.6 4.9 .3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3 .7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3 .3 2.9 2.3 3.9 1.6 1 3.6 .7 4.3-.7 .7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3 .7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3 .7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"/></svg>
					<span>{{ $t('wuc.buttons.github') }}</span>
				</a>
				<a class="group mx-auto flex items-center justify-between w-xs h-13 border-2 border-solid border-sky-600 text-sky-600 rounded-3xl my-3 font-bold bg-neutral-950/40 hover:scale-102 hover:text-white hover:border-white hover:bg-sky-600 transition-all duration-350 ease-in-out after:content-['']" rel="external noopener" :href="route('external.telegram.bot')" target="_blank">
					<svg class="justify-self-start pl-3 scale-225 size-6 mr-2 fill-sky-600 group-hover:fill-white transition-colors duration 350 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M320 0c17.7 0 32 14.3 32 32l0 64 120 0c39.8 0 72 32.2 72 72l0 272c0 39.8-32.2 72-72 72l-304 0c-39.8 0-72-32.2-72-72l0-272c0-39.8 32.2-72 72-72l120 0 0-64c0-17.7 14.3-32 32-32zM208 384c-8.8 0-16 7.2-16 16s7.2 16 16 16l32 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-32 0zm96 0c-8.8 0-16 7.2-16 16s7.2 16 16 16l32 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-32 0zm96 0c-8.8 0-16 7.2-16 16s7.2 16 16 16l32 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-32 0zM264 256a40 40 0 1 0 -80 0 40 40 0 1 0 80 0zm152 40a40 40 0 1 0 0-80 40 40 0 1 0 0 80zM48 224l16 0 0 192-16 0c-26.5 0-48-21.5-48-48l0-96c0-26.5 21.5-48 48-48zm544 0c26.5 0 48 21.5 48 48l0 96c0 26.5-21.5 48-48 48l-16 0 0-192 16 0z"/></svg>
					<span>{{ $t('wuc.buttons.telegram_bot') }}</span>
				</a>
			</nav>
		</section>
		<!--/sse-->
	</main>
	<footer class="w-full mr-auto bg-neutral-950/80 min-h-85 pt-5 z-20 shadow-[0_-5px_10px_2px_rgba(10,10,10,0.5)]">
		<div class="flex items-center justify-center flex-wrap mx-auto mt-auto max-w-7xl w-full">
			<section class="grow shrink-0 basis-7/10 text-xs sm:min-w-xl">
				<h2 class="text-3xl font-bold mb-3">{{ $t('footer.org.name') }}</h2>
				<p class="*:hover:underline" v-html="$t('footer.org.description')"></p>
				<p class="*:hover:underline" v-html="$t('footer.org.runts', {
							url: route('external.MLPS.runts'),
							date: runtsDateStr,
							repno: runtsArchiveNumber,
				})"></p>
				<p class="*:hover:underline" v-html="$t('footer.org.affiliations', {
							tdgurl: route('external.goblins.associations.garfaludica'),
							federludourl: route('external.federludo.associations.garfaludica'),
							aicsurl: route('external.aics.home'),
				})"></p>
				<p>
					<template v-for="document in documents" :key="document.name">
						<a class="hover:underline" rel="noopener" :href="document.url" target="_blank">
							{{ $t(document.name) }}
						</a>
						<span v-if="document !== documents[documents.length - 1]"> | </span>
					</template>
				</p>
				<p class="*:hover:underline" v-html="$t('footer.org.office', {
							address: officeAddress,
							url: route('external.gmaps.registeredOffice'),
				})"></p>
				<p>{{ $t('footer.org.tax_id_code') }}: <a @click="copyToClipboard(taxIdCode)" class="hover:underline cursor-pointer">{{ $t(taxIdCode) }}</a></p>
				<p>{{ $t('footer.org.iban') }}: <a @click="copyToClipboard(iban)" class="hover:underline cursor-pointer">{{ $t(iban) }}</a></p>
				<!--sse-->
				<p>
					<a class="hover:underline" rel="noopener" :href="`mailto:${emailAddress}`" target="_blank">
						{{ $t(emailAddress) }}
					</a> |
					<a class="hover:underline" rel="noopener" :href="`mailto:${certifiedEmailAddress}`" target="_blank">
						{{ $t(certifiedEmailAddress) }}
					</a>
				</p>
				<p>
					{{ $t('footer.org.presidency') }}: <a class="hover:underline" rel="noopener" :href="`tel:${presidentInfo.phone}`" target="_blank">
						{{ $t(presidentInfo.phone) }}
					</a>
					(<a class="hover:underline" rel="external noopener" :href="presidentInfo.url" target="_blank">
						{{ $t(presidentInfo.name) }}
					</a>) | {{ $t('footer.org.secretariat') }}: <a class="hover:underline" rel="noopener" :href="`tel:${secretaryInfo.phone}`" target="_blank">
						{{ $t(secretaryInfo.phone) }}
					</a>
					(<a class="hover:underline" rel="external noopener" :href="secretaryInfo.url" target="_blank">
						{{ $t(secretaryInfo.name) }}
					</a>)<br>
					{{ $t('footer.org.vice_presidency') }}: <a class="hover:underline" rel="external noopener" :href="vicePresidentInfo.url" target="_blank">
						{{ $t(vicePresidentInfo.name) }}
					</a> | {{ $t('footer.org.councillors') }}:
					<template v-for="councillor in councillorsInfo" :key="councillor.name">
						<a class="hover:underline" rel="external noopener" :href="councillor.url" target="_blank">
							{{ $t(councillor.name) }}
						</a>
						<span v-if="councillor !== councillorsInfo[councillorsInfo.length - 1]">, </span>
						<span v-else>.</span>
					</template>
				</p>
				<!--/sse-->
				<div class="mt-2" id="donate-button-container">
					<div id="donate-button"></div>
				</div>
			</section>
			<section class="grow shrink-0 basis-3/10">
				<div class="w-3xs lg:ml-auto">
					<a class="m-3 inline-block" rel="external noopener" :href="route('external.goblins.associations.garfaludica')" target="_blank">
						<img :src="logoTdgUrl" width="100" height="104.6" :alt="$t('Logo Tana dei Goblin di Castelnuovo di Garfagnana')">
					</a>
					<a class="m-3 inline-block" rel="external noopener" :href="route('external.federludo.associations.garfaludica')" target="_blank">
						<img :src="logoFederludoUrl" width="100" height="100" :alt="$t('Logo Federludo A.P.S.')">
					</a>
				</div>
				<div class="w-3xs lg:ml-auto">
					<a class="inline-block m-3" rel="external noopener" :href="route('external.aics.home')" target="_blank">
						<img :src="logoAicsUrl" width="200" height="85.2833" :alt="$t('Logo Associazione Italiana Cultura e Sport')">
					</a>
				</div>
			</section>
			<p class="mt-10 italic text-neutral-300 w-full text-xs text-center">
			<span v-html="$t('footer.cookie_policy')"></span><br>
				<!--sse-->
				<a class="not-italic hover:underline" rel="noopener" :href="`mailto:${privacyEmailAddress}`" target="_blank">
					{{ $t(privacyEmailAddress) }}
				</a>
				<!--/sse-->
				<span class="not-italic">&nbsp;|&nbsp;</span>
				<a class="not-italic hover:underline" rel="external noopener" :href="route('external.cloudflare.privacyPolicy')" target="_blank">
					{{ $t('footer.cf_privacy_policy') }}
				</a>
			</p>
			<p class="mt-2 mb-1 italic text-neutral-300 w-full text-s text-center">
				{{ $t('footer.copyright_line_1') }} (<a class="hover:underline" :href="licenseUrl" target="_blank">{{ $t('footer.license') }}</a>)
				<br>
				{{ $t('footer.copyright_line_2') }}
			</p>
		</div>
	</footer>
	<div :style="toastOpacityStyle" class="fixed bottom-[2vh] left-1/2 bg-neutral-900 text-white p-4 z-50 border border-neutral-900 rounded-4xl transition-opacity duration-1000 ease-in-out shadow-lg -translate-x-1/2">{{ toastText }}</div>
</template>
