<script setup lang="ts">
	import { defineComponent, h } from 'vue';
	import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/24/outline';

	const telegramIcon = defineComponent({
		render: () =>
			h('svg', { fill: 'currentColor', viewBox: '0 0 24 24' }, [
				h('path', {
					'fill-rule': 'evenodd',
					d: 'M11.953 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2a10 10 0 0 0-.047 0zm4.135 6.02c.083-.002.268 .019.388 .117a.422.422 0 0 1 .142.271c.013.077 .03.255 .017.393-.15 1.582-.802 5.418-1.133 7.189-.14.75-.416 1.001-.683 1.025-.58.054-1.021-.383-1.583-.752-.88-.578-1.377-.937-2.232-1.5-.988-.65-.348-1.008.215-1.592.147-.153 2.706-2.481 2.756-2.692.006-.027.012-.125-.047-.177s-.145-.034-.208-.02c-.088.02-1.494.95-4.218 2.788-.4.275-.761.408-1.085.4-.357-.007-1.043-.201-1.554-.367-.627-.204-1.124-.312-1.081-.657.023-.18.271-.364.744-.553 2.915-1.27 4.858-2.107 5.832-2.512 2.777-1.155 3.354-1.356 3.73-1.362z',
					'clip-rule': 'evenodd',
				}),
			]),
	});

	defineProps({
		contactOptions: {
			type: Array,
			required: true,
		},
	});
</script>

<template>
	<div class="bg-white py-8 sm:py-16">
		<!--sse-->
		<FadeInView class="mx-auto max-w-7xl px-6 lg:px-8">
			<div class="mx-auto max-w-2xl divide-y divide-gray-100 lg:mx-0 lg:max-w-none">
				<div class="grid grid-cols-1 gap-10 py-16 lg:grid-cols-3">
					<div>
						<h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-900">{{ $t('gobcon.contact_us.title') }}</h2>
						<p class="mt-4 text-base/7 text-gray-600">{{ $t('gobcon.contact_us.subtitle') }}</p>
					</div>
					<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:col-span-2 lg:gap-8">
						<FadeInView speed="slow" delay="large" v-for="item in contactOptions" :key="item.title" class="rounded-2xl bg-gray-50 p-10">
							<h3 class="text-base/7 font-semibold text-gray-900">{{ $t(item.title) }}</h3>
							<dl class="mt-3 space-y-1 text-sm/6 text-gray-600">
								<div v-if="item.email">
									<dt class="sr-only">{{ $t('Email') }}</dt>
									<dd><EnvelopeIcon class="inline size-4" />&nbsp;<a class="font-semibold text-indigo-600" :href="'mailto:' + item.email" rel="external noopener" target="_blank">{{ item.email }}</a></dd>
								</div>
								<div v-if="item.phone" class="mt-1">
									<dt class="sr-only">{{ $t('Phone number') }}</dt>
									<dd><PhoneIcon class="inline size-4" />&nbsp;<a :href="'tel:' + item.phone" rel="external noopener" target="_blank">{{ $t(item.phone) }}</a></dd>
								</div>
								<div v-if="item.telegram" class="mt-1">
									<dt class="sr-only">{{ $t('Telegram') }}</dt>
									<dd><component :is="telegramIcon" class="inline size-4" />&nbsp;<a class="text-indigo-600" :href="'https://' + item.telegram" rel="external noopener" target="_blank">{{ item.telegram }}</a></dd>
								</div>
							</dl>
						</FadeInView>
					</div>
				</div>
			</div>
		</FadeInView>
		<!--/sse-->
	</div>
</template>
