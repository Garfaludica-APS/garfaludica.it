<script setup lang="ts">
import { inject } from "vue";
import { useForm } from "@inertiajs/vue3";

const route = inject("route");

const form = useForm({
	email: null,
});

function submit() {
	form.post(route("gobcon.booking.start"), { preserveScroll: true });
}
</script>

<template>
	<div
		class="-mt-100 relative isolate overflow-hidden bg-gray-900 px-6 py-28 shadow-2xl sm:px-24 xl:py-36"
	>
		<FadeInView>
			<h2
				class="mx-auto max-w-3xl text-center text-4xl font-semibold tracking-tight text-white sm:text-5xl"
			>
				{{ $t("gobcon.book_section.book_now") }}
			</h2>
		</FadeInView>
		<!--sse-->
		<FadeInView speed="slow" delay="small">
			<p class="mx-auto mt-6 max-w-lg text-center text-lg text-gray-300">
				{{ $t("gobcon.book_section.subtitle") }}
			</p>
		</FadeInView>
		<FadeInView speed="slow" delay="large">
			<div class="mx-auto mt-10 max-w-md">
				<form
					class="mx-auto mt-10 flex max-w-md gap-x-4"
					@submit.prevent="submit"
				>
					<label for="email-address" class="sr-only">{{
						$t("Email address")
					}}</label>
					<input
						id="email-address"
						name="email"
						type="email"
						autocomplete="email"
						v-model="form.email"
						required=""
						class="min-w-0 flex-auto rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-white sm:text-sm/6"
						:placeholder="
							$t('gobcon.notify_me_section.enter_your_email')
						"
					/>
					<button
						type="submit"
						:disabled="form.processing"
						class="flex-none rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
					>
						{{ $t("gobcon.book_now") }}
					</button>
				</form>
				<p
					v-if="form.errors.email"
					class="block mt-2 text-sm text-red-500"
				>
					{{ form.errors.email }}
				</p>
				<p
					v-if="form.wasSuccessful"
					class="block mt-2 text-sm text-green-500"
				>
					{{ $t("gobcon.book_start_success") }}
				</p>
			</div>
		</FadeInView>
		<!--/sse-->
		<svg
			viewBox="0 0 1024 1024"
			class="absolute top-1/2 left-1/2 -z-10 size-[64rem] -translate-x-1/2"
			aria-hidden="true"
		>
			<circle
				cx="512"
				cy="512"
				r="512"
				fill="url(#759c1415-0410-454c-8f7c-9a820de03641)"
				fill-opacity="0.7"
			/>
			<defs>
				<radialGradient
					id="759c1415-0410-454c-8f7c-9a820de03641"
					cx="0"
					cy="0"
					r="1"
					gradientUnits="userSpaceOnUse"
					gradientTransform="translate(512 512) rotate(90) scale(512)"
				>
					<stop stop-color="#7775D6" />
					<stop offset="1" stop-color="#E935C1" stop-opacity="0" />
				</radialGradient>
			</defs>
		</svg>
	</div>
</template>
