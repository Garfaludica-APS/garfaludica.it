<script setup lang="ts">
	defineProps({
		eventYear: [String, Number],
		infoSections: Array,
		photo1: String,
		photo2: String,
		photo3: String,
		photo4: String,
		tdgLogo: String,
	});
</script>

<template>
	<div class="overflow-hidden bg-white py-24 sm:py-32">
		<div class="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
			<FadeInView class="max-w-4xl">
				<p class="text-base/7 font-semibold text-indigo-600 uppercase">{{ $t('gobcon.title', { year: eventYear }) }}</p>
				<h1 class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">{{ $t('gobcon.info.title') }}</h1>
				<p class="mt-6 text-xl/8 text-balance text-gray-700">{{ $t('gobcon.info.subtitle') }}</p>
				<p class="mt-6 text-xl/8 text-balance text-indigo-600">{{ $t('gobcon.info.date_details', {
					start_date: $t('friday 20 june'),
					start_time: '10:00',
					end_date: $t('sunday 22 june'),
					end_time: '19:00',
				}) }}</p>
			</FadeInView>
			<section class="mt-6 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-8 lg:gap-y-16">
				<div class="lg:pr-8">
					<template v-for="sec in infoSections" :key="sec.title">
						<FadeInView>
							<h2 class="pt-12 text-2xl font-semibold tracking-tight text-pretty text-gray-900">{{ $t(sec.title) }}</h2>
						</FadeInView>
						<FadeInView delay="medium">
							<p v-for="par in sec.paragraphs" class="mt-6 text-base/7 text-gray-600">{{ $t(par) }}</p>
						</FadeInView>
					</template>
				</div>
				<div class="pt-16 lg:row-span-2 lg:-mr-16 xl:mr-auto">
					<div class="-mx-8 grid grid-cols-2 gap-4 sm:-mx-16 sm:grid-cols-4 lg:mx-0 lg:grid-cols-2 lg:gap-4 xl:gap-8">
						<FadeInView class="aspect-square overflow-hidden rounded-xl shadow-xl outline-1 -outline-offset-1 outline-black/10">
							<img alt="" :src="photo1" class="block size-full object-cover" />
						</FadeInView>
						<FadeInView class="-mt-8 aspect-square overflow-hidden rounded-xl shadow-xl outline-1 -outline-offset-1 outline-black/10 lg:-mt-40">
							<img alt="" :src="photo2" class="block size-full object-cover" />
						</FadeInView>
						<FadeInView class="aspect-square overflow-hidden rounded-xl shadow-xl outline-1 -outline-offset-1 outline-black/10">
							<img alt="" :src="photo3" class="block size-full object-cover" />
						</FadeInView>
						<FadeInView class="-mt-8 aspect-square overflow-hidden rounded-xl shadow-xl outline-1 -outline-offset-1 outline-black/10 lg:-mt-40">
							<img alt="" :src="photo4" class="block size-full object-cover" />
						</FadeInView>
					</div>
					<FadeInView>
						<img class="mt-8" :src="tdgLogo" alt="" />
					</FadeInView>
				</div>
			</section>
		</div>
	</div>
</template>
