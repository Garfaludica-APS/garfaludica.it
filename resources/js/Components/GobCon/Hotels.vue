<script setup lang="ts">
	import { HomeModernIcon, MapPinIcon } from '@heroicons/vue/24/outline';

	defineProps({
		hotels: {
			type: Array as PropType<{ name: string, description: string, address: string, gmaps: string }[]>,
			required: true
		},
	});
</script>

<template>
	<div class="bg-background pb-20 sm:pb-24 xl:pb-0">
		<FadeInView class="mx-auto flex max-w-7xl flex-col items-center gap-x-8 gap-y-10 px-6 sm:gap-y-8 lg:px-8 xl:flex-row xl:items-stretch">
			<div class="-mt-8 2xl:-ml-30 w-full max-w-2xl xl:-mb-8 xl:w-120 xl:flex-none">
				<div class="relative aspect-2/1 h-full md:-mx-8 xl:mx-0 xl:aspect-auto">
					<slot name="media" />
				</div>
			</div>
			<div class="w-full max-w-2xl xl:max-w-none xl:flex-auto xl:px-16 xl:py-24">
				<div class="relative isolate">
					<HomeModernIcon class="absolute top-8 left-0 -z-10 h-64 stroke-white/10" />
					<h2 class="text-4xl font-semibold tracking-tight text-pretty text-foreground">{{ $t('gobcon.hotels.title') }}</h2>
					<div class="mt-12 grid grid-cols-1 gap-4 sm:grid-cols-2 text-white">
						<FadeInView speed="slow" delay="large" v-for="hotel in hotels" :key="hotel.name" class="relative flex items-center space-x-3 rounded-lg border border-gray-300 px-6 py-5">
							<div class="min-w-0 flex-1">
								<p class="text-xl/8 font-semibold">{{ $t(hotel.name) }}</p>
								<p class="mt-1 text-wrap text-base">{{ $t(hotel.description) }}</p>
								<a :href="hotel.gmaps" rel="external noopener" target="_blank" class="inline-block mt-4 text-sm text-indigo-500 hover:text-indigo-400">
									<MapPinIcon class="w-5 h-5 inline" />&nbsp;
									<span class="text-sm/6">{{ $t(hotel.address) }}</span>
								</a>
							</div>
						</FadeInView>
					</div>
				</div>
			</div>
		</FadeInView>
	</div>
</template>
