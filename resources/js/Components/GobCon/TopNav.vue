<script setup lang="ts">
	import { inject, ref } from 'vue';
	import { Bars3Icon, GlobeAltIcon, XMarkIcon } from '@heroicons/vue/24/outline';

	const getActiveLanguage = inject('getActiveLanguage');
	const loadLanguage = inject('loadLanguage');

	defineProps({
		navItems: Array,
		appMark: String,
	});

	const currentLang = ref(getActiveLanguage());

	function changeLanguage(lang: string)
	{
		if (lang === getActiveLanguage())
			return;
		loadLanguage(lang);
	}

	function scrollTo(section: Ref<HTMLElement | null>)
	{
		section.value?.scrollIntoView({ behavior: 'smooth' });
	};

	const mobileMenuOpen = ref(false);
</script>

<template>
	<header class="absolute inset-x-0 top-0 z-50">
		<nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
			<div class="flex lg:flex-1">
				<a href="https://www.garfaludica.it" target="_blank" class="-m-1.5 p-1.5">
					<span class="sr-only">{{ $t('Garfaludica APS') }}</span>
						<img class="h-8 w-auto" :src="appMark" alt="" />
				</a>
			</div>
			<div class="flex lg:hidden">
				<button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-dimmed-foreground" @click="mobileMenuOpen = true">
					<span class="sr-only">{{ $t('gobcon.open_main_menu') }}</span>
					<Bars3Icon class="size-6" aria-hidden="true" />
				</button>
			</div>
			<div class="hidden lg:flex lg:gap-x-12">
				<button v-for="item in navItems" :key="item.name" @click="scrollTo(item.section)" class="text-sm/6 font-semibold text-foreground hover:cursor-pointer">{{ $t(item.name) }}</button>
			</div>
			<div class="hidden lg:flex lg:flex-1 lg:justify-end">
				<GlobeAltIcon class="size-4 inline-block mr-1" />
				<select class="text-sm/6 font-semibold text-foreground hover:cursor-pointer" v-model="currentLang" @change="changeLanguage($event.target.value)">
					<option value="it">{{ $t('ITA') }}</option>
					<option value="en">{{ $t('ENG') }}</option>
				</select>
			</div>
		</nav>
		<TransitionRoot as="template" :show="mobileMenuOpen">
			<Dialog class="lg:hidden" @close="mobileMenuOpen = false">
				<TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
					<div class="fixed inset-0 bg-gray-500/50 transition-opacity" />
				</TransitionChild>
				<div class="fixed inset-0 z-50" />
				<TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
					<DialogPanel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-background px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-white/10">
						<div class="flex items-center justify-between">
							<a href="#" class="-m-1.5 p-1.5">
								<span class="sr-only">{{ $t('Garfaludica APS') }}</span>
								<img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" />
							</a>
							<button type="button" class="-m-2.5 rounded-md p-2.5 text-dimmed-foreground" @click="mobileMenuOpen = false">
								<span class="sr-only">{{ $t('gobcon.close_menu') }}</span>
								<XMarkIcon class="size-6" aria-hidden="true" />
							</button>
						</div>
						<div class="mt-6 flow-root">
							<div class="-my-6 divide-y divide-gray-500/25">
								<div class="space-y-2 py-6">
									<button v-for="item in navItems" :key="item.name" @click="scrollTo(item.section); mobileMenuOpen = false" class="-mx-3 block w-full text-left rounded-lg px-3 py-2 text-base/7 font-semibold text-foreground hover:bg-navbtn-hover hover:cursor-pointer">{{ item.name }}</button>
								</div>
								<div class="py-6">
									<select class="-mx-3 block rounded-lg px-3 py-2.5 text-foreground hover:bg-navbtn-hover w-full text-base/7 font-semibold hover:cursor-pointer" v-model="currentLang" @change="changeLanguage($event.target.value)">
										<option value="it">{{ $t('Italian') }}</option>
										<option value="en">{{ $t('English') }}</option>
									</select>
								</div>
							</div>
						</div>
					</DialogPanel>
				</TransitionChild>
			</Dialog>
		</TransitionRoot>
	</header>
</template>
