<script lang="ts">
// import BaseLayout from "@/Layouts/BaseLayout.vue";

// export default {
// 	layout: (h, page) => h(BaseLayout, {}, () => page),
// };
</script>

<script setup lang="ts">
import { inject, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";

defineProps({
	appMark: String,
	photo1: String,
	photo2: String,
	photo3: String,
	photo4: String,
	tdgLogo: String,
	heroImage: String,
	heroVideo: String,
	appScreenshot: String,
	socialImage: String,
	faqs: Array,
});

const hotels = [
	{
		name: "gobcon.hotels.isera.name",
		description: "gobcon.hotels.isera.description",
		address: "gobcon.hotels.isera.address",
		gmaps: "https://maps.app.goo.gl/CLnLnrixq6CL6d18A",
	},
	{
		name: "gobcon.hotels.panoramico.name",
		description: "gobcon.hotels.panoramico.description",
		address: "gobcon.hotels.panoramico.address",
		gmaps: "https://maps.app.goo.gl/AuAMBsqRAzeALRVY7",
	},
	{
		name: "gobcon.hotels.braccicorti.name",
		description: "gobcon.hotels.braccicorti.description",
		address: "gobcon.hotels.braccicorti.address",
		gmaps: "https://maps.app.goo.gl/nhAqtqG9GYaPTQp36",
	},
	{
		name: "gobcon.hotels.camper.name",
		description: "gobcon.hotels.camper.description",
		address: "gobcon.hotels.camper.address",
		gmaps: "https://maps.app.goo.gl/4iJL94HR3QXDAx2a6",
	},
];

const infoSections = [
	{
		title: "gobcon.info.section_1.title",
		paragraphs: [
			"gobcon.info.section_1.paragraph_1",
			"gobcon.info.section_1.paragraph_2",
			"gobcon.info.section_1.paragraph_3",
			"gobcon.info.section_1.paragraph_4",
		],
	},
	{
		title: "gobcon.info.section_2.title",
		paragraphs: [
			"gobcon.info.section_2.paragraph_1",
			"gobcon.info.section_2.paragraph_2",
		],
	},
];

const infoSection = ref<HTMLElement | null>(null);
const communitySection = ref<HTMLElement | null>(null);
const bookSection = ref<HTMLElement | null>(null);
const faqSection = ref<HTMLElement | null>(null);
const contactSection = ref<HTMLElement | null>(null);

const topNavigation = [
	{ name: "gobcon.navigation.info", section: infoSection },
	{ name: "gobcon.navigation.community", section: communitySection },
	{ name: "gobcon.navigation.book", section: bookSection },
	{ name: "gobcon.navigation.faq", section: faqSection },
	{ name: "gobcon.navigation.contact", section: contactSection },
];

const eventYear = 2025;

const contactOptions = [
	{
		title: "gobcon.contact_us.event_organization",
		email: "info@garfaludica.it",
		phone: "+393282228615",
		telegram: "t.me/gobcongarfagnana",
	},
	{
		title: "gobcon.contact_us.technical_support",
		email: "info@garfaludica.it",
		phone: "+393314432124",
		telegram: "t.me/SpeedJack",
	},
	{
		title: "gobcon.contact_us.association",
		email: "info@garfaludica.it",
		phone: "+393247460610",
		telegram: "t.me/associazionegarfaludica",
	},
	{
		title: "gobcon.contact_us.privacy",
		email: "privacy@garfaludica.it",
		phone: "+393314432124",
	},
];
</script>

<template>
	<Head>
		<title>{{ $t("gobcon.title", { year: eventYear }) }}</title>
		<meta
			head-key="description"
			name="description"
			:content="$t('gobcon.description')"
		/>
		<meta
			head-key="keywords"
			name="keywords"
			:content="$t('gobcon.keywords')"
		/>
		<meta head-key="color-scheme" name="color-scheme" content="dark" />
		<meta head-key="theme-color" name="theme-color" content="#101828" />
		<meta
			property="og:title"
			:content="$t('gobcon.title', { year: eventYear })"
		/>
		<meta property="og:image" :content="socialImage" />
		<link rel="canonical" :href="route('gobcon.home')" />
		<link rel="alternate" hreflang="it" :href="ziggy('gobcon.home')" />
		<link rel="alternate" hreflang="en" :href="ziggy('en.gobcon.home')" />
		<link rel="x-default" :href="ziggy('en.gobcon.home')" />
	</Head>
	<main>
		<GobCon-Hero
			:appMark="appMark"
			:navItems="topNavigation"
			:eventYear="eventYear"
			eventDate="20-22 Giugno"
			eventLocation="Corfino, Villa Collemandina, Lucca"
			:bgImage="heroImage"
		>
			<template #announcement>
				{{ $t("gobcon.announcement") }}
				<button
					@click="bookSection?.scrollIntoView({ behavior: 'smooth' })"
					class="font-semibold text-white inline hover:cursor-pointer"
				>
					<span class="absolute inset-0" aria-hidden="true" />{{
						$t("gobcon.book_now")
					}}
					<span aria-hidden="true">&rarr;</span>
				</button>
			</template>
			<template #actions>
				<button
					@click="bookSection?.scrollIntoView({ behavior: 'smooth' })"
					class="rounded-md bg-primary-btn px-3.5 py-2.5 text-sm font-semibold text-foreground shadow-xs hover:bg-primary-btn-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-btn-hover hover:cursor-pointer"
				>
					{{ $t("gobcon.book_now") }}
				</button>
				<button
					@click="infoSection?.scrollIntoView({ behavior: 'smooth' })"
					class="text-sm/6 font-semibold text-foreground hover:cursor-pointer"
				>
					{{ $t("gobcon.learn_more") }}
					<span aria-hidden="true">→</span>
				</button>
			</template>
		</GobCon-Hero>

		<article ref="infoSection">
			<GobCon-Info
				:photo1="photo1"
				:photo2="photo2"
				:photo3="photo3"
				:photo4="photo4"
				:tdgLogo="tdgLogo"
				:eventYear="eventYear"
				:infoSections="infoSections"
			/>
		</article>

		<section
			class="bg-gradient-to-b from-white from-50% to-indigo-400 to-50% pb-16 sm:pb-24 xl:pb-32"
		>
			<GobCon-Hotels :hotels="hotels">
				<template #media>
					<video
						class="absolute inset-0 size-full rounded-2xl bg-gray-800 object-cover shadow-2xl"
						autoplay
						muted
						loop
					>
						<source :src="heroVideo" type="video/mp4" />
					</video>
				</template>
			</GobCon-Hotels>
			<div ref="communitySection" />
		</section>
	</main>

	<aside>
		<GobCon-Community :appScreenshot="appScreenshot" />
	</aside>

	<section ref="bookSection">
		<!-- <GobCon-NotifyMe /> -->
		<GobCon-Book />
	</section>

	<section ref="faqSection">
		<GobCon-Faq :faqs="faqs" />
	</section>

	<aside ref="contactSection">
		<GobCon-Contact :contactOptions="contactOptions" />
	</aside>

	<Footer-Simple />
</template>
