<!-- Copyright © 2025 - Garfaludica APS - MIT License -->

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const props = usePage().props;
</script>

<template>
	<Head title="Voting Portal" />
	<div class="flex min-h-screen flex-1 flex-col justify-between">
		<div
			class="flex min-h-full flex-1 flex-col justify-start py-12 sm:px-6 lg:px-8"
		>
			<header class="sm:mx-auto sm:w-full sm:max-w-lg">
				<img
					class="mx-auto h-20 w-auto"
					:src="props.logoUrl"
					:alt="$t('Logo Garfaludica APS')"
				/>
				<h2
					class="mt-6 text-center text-2xl/9 font-bold tracking-tight text-foreground"
				>
					Elezioni Consiglio Direttivo 2025
				</h2>
			</header>
			<main class="mt-10 sm:mx-auto sm:w-full sm:max-w-lg">
				<div
					class="bg-card-background px-6 py-12 shadow-sm sm:rounded-lg sm:px-12"
				>
					<div class="flex flex-col space-y-2">
						<slot />
					</div>
				</div>
			</main>
		</div>
		<Footer-Minimal />
	</div>
</template>
