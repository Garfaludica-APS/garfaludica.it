<script lang="ts">
import VoteLayout from "@/Layouts/VoteLayout.vue";

export default {
	layout: (h, page) => h(VoteLayout, {}, () => page),
};
</script>

<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import { inject } from "vue";

const route = inject("route");

const props = defineProps({
	member: Object,
	token: String,
});

const handleSubmit = () => {
	router.post(
		route("vote.election.verify", {
			token: props.token,
			member: props.member,
		}),
	);
};
</script>

<template>
	<div class="flex flex-row space-x-6 text-lg">
		<span class="font-semibold">Nome:</span>
		<span>
			{{ member.name }}
		</span>
	</div>
	<div class="flex flex-row space-x-6 text-lg">
		<span class="font-semibold">Tessera:</span>
		<span>
			{{ member.id }}
		</span>
	</div>
	<span class="mt-6 font-bold">Deleganti:</span>
	<span
		v-if="member.delegators && member.delegators.length > 0"
		class="text-sm"
		>Voterai anche per:</span
	>
	<ul
		v-if="member.delegators && member.delegators.length > 0"
		class="list-disc pl-6"
	>
		<li v-for="delegate in member.delegators" :key="delegate.id">
			{{ delegate.name }} ({{ delegate.id }})
		</li>
	</ul>
	<span v-else class="text-gray-500">
		Non ci sono deleghe attive: voterai solo per te stesso.
	</span>
	<span class="mt-6 text-sm text-red-200"
		>Se ci sono errori nei dati, informa un membro del Consiglio
		Direttivo.</span
	>
	<button
		class="w-full mt-6 flex justify-center rounded-md bg-primary-btn px-3 py-2 text-sm/6 font-semibold text-white shadow-xs hover:bg-primary-btn-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-btn disabled:bg-primary-btn-disabled"
		@click="handleSubmit"
	>
		Conferma dati
	</button>
</template>
