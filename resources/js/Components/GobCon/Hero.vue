<script setup lang="ts">
	import { defineComponent, h } from 'vue';
	import { trans } from 'laravel-vue-i18n';

	const props = defineProps({
		navItems: Array,
		eventYear: [String, Number],
		eventDate: String,
		eventLocation: String,
		bgImage: String,
		appMark: String,
	});

	const eventTitle = defineComponent({
		render: () => h('h1',
			{ },
			[
				h('span',
					{
						class: 'text-green-600'
					},
					trans('GobCon')
				),
				'\u00A0' + props.eventYear + ' ' + trans('Garfagnana'),
			]
		),
	});
</script>

<template>
	<div class="bg-background">
		<GobCon-TopNav :appMark="appMark" :navItems="navItems" />

		<div class="relative isolate overflow-hidden pt-14">
			<img :src="bgImage" alt="" class="absolute inset-0 -z-10 size-full object-cover" />
			<div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
				<div class="relative left-[calc(50%-11rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
			</div>
			<div class="mx-auto max-w-7xl px-6 lg:px-8">
				<div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
					<FadeInView delay="small" v-if="$slots.announcement" class="hidden sm:mb-8 sm:flex sm:justify-center">
						<div class="relative rounded-full px-3 py-1 text-sm/6 text-dimmed-foreground ring-1 ring-white/10 hover:ring-white/20">
							<slot name="announcement" />
						</div>
					</FadeInView>
					<FadeInView class="text-center">
						<component :is="eventTitle" class="text-4xl xs:text-6xl font-semibold tracking-tight text-balance text-foreground sm:text-8xl uppercase"></component>
						<p class="mt-8 text-lg font-medium text-pretty text-dimmed-foreground sm:text-xl/8">{{ $t('gobcon.description') }}<br><br>
							<span class="text-xl sm:text-2xl/8 text-green-600">{{ $t('gobcon.date_location', { date: '20-22 Giugno', location: 'Corfino, Villa Collemandina, Lucca' }) }}</span>
						</p>
						<FadeInView delay="medium" v-if="$slots.actions" class="mt-10 flex items-center justify-center gap-x-6">
							<slot name="actions" />
						</FadeInView>
					</FadeInView>
				</div>
			</div>
			<div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
				<div class="relative left-[calc(50%+3rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
			</div>
		</div>
	</div>
</template>
