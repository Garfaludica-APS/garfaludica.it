<script setup lang="ts">
	import { computed } from 'vue';
	import { MinusSmallIcon, PlusSmallIcon } from '@heroicons/vue/24/outline';
	const props = defineProps({
		faqs: {
			type: Array,
			required: true,
		},
	});

	const structuredFaqs = computed(() => {
		return props.faqs.map((faq) => ({
			question: `gobcon.faqs.${faq}.question`,
			answer: `gobcon.faqs.${faq}.answer`,
		}));
	});
</script>

<template>
	<div class="bg-white">
		<FadeInView class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40">
			<div class="mx-auto max-w-4xl">
				<h2 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">{{ $t('gobcon.faqs.title') }}</h2>
				<dl class="mt-16 divide-y divide-gray-900/10">
					<FadeInView speed="slow" delay="large" v-for="faq in structuredFaqs" :key="faq.question">
						<Disclosure as="div" class="py-6 first:pt-0 last:pb-0" v-slot="{ open }">
							<dt>
								<DisclosureButton class="flex w-full items-start justify-between text-left text-gray-900">
									<span class="text-base/7 font-semibold">{{ $t(faq.question) }}</span>
									<span class="ml-6 flex h-7 items-center">
										<PlusSmallIcon v-if="!open" class="size-6" aria-hidden="true" />
										<MinusSmallIcon v-else class="size-6" aria-hidden="true" />
									</span>
								</DisclosureButton>
							</dt>
							<transition
								enter-active-class="transition duration-300 ease-out"
								enter-from-class="transform scale-y-50 opacity-0"
								enter-to-class="transform scale-y-100 opacity-100"
								leave-active-class="transition duration-75 ease-out"
								leave-from-class="transform scale-y-100 opacity-100"
								leave-to-class="transform scale-y-50 opacity-0"
							>
								<DisclosurePanel as="dd" class="mt-2 pr-12">
									<p class="text-base/7 text-gray-600" v-html="$t(faq.answer)"></p>
								</DisclosurePanel>
							</transition>
						</Disclosure>
					</FadeInView>
				</dl>
			</div>
		</FadeInView>
	</div>
</template>
