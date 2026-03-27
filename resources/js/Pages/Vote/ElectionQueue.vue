<script lang="ts">
import VoteLayout from "@/Layouts/VoteLayout.vue";

export default {
	layout: (h, page) => h(VoteLayout, {}, () => page),
};
</script>

<script setup lang="ts">
import { usePoll } from "@inertiajs/vue3";

usePoll(3000);
</script>

<template>
	<div class="flex flex-row items-center justify-between gap-6">
		<div>
			<div
				className="box-border size-8 animate-spin rounded-full border-4 border-gray-200 border-b-transparent select-none"
			></div>
		</div>
		<h1 className="text-3xl font-bold">
			In attesa di istruzioni dal Consiglio Direttivo...
		</h1>
	</div>
	<span class="text-gray-300">
		Le votazioni inizieranno a breve. Non chiudere questa pagina.
	</span>
</template>
