<script lang="ts">
import VoteLayout from "@/Layouts/VoteLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";

export default {
	layout: (h, page) => h(VoteLayout, {}, () => page),
};
</script>

<script setup lang="ts">
import { inject, ref } from "vue";
import {
	Dialog,
	DialogPanel,
	DialogTitle,
	TransitionChild,
	TransitionRoot,
} from "@headlessui/vue";

const route = inject("route");

const confirmOpen = ref(false);

const props = defineProps({
	ballot: Object,
});

const form = useForm({
	selected: [],
});

const isSelected = (optionId: number) => {
	return form.selected.includes(optionId);
};

const toggleOption = (optionId: number) => {
	if (props.ballot.max_votes === 1) {
		form.selected = isSelected(optionId) ? [] : [optionId];
	} else {
		if (isSelected(optionId)) {
			form.selected = form.selected.filter((id) => id !== optionId);
		} else if (form.selected.length < props.ballot.max_votes) {
			form.selected.push(optionId);
		}
	}
};

const getOptionName = (option) => {
	if (option.value) {
		switch (option.value) {
			case 3:
				return "3 (tre)";
			case 5:
				return "5 (cinque)";
			case 7:
				return "7 (sette)";
			case 9:
				return "9 (nove)";
		}
	} else if (option.candidate) {
		return option.candidate.name + " (" + option.candidate.id + ")";
	} else {
		return "Unknown Option";
	}
};

const voteOptions = computed(() => {
	return props.ballot.vote_options
		.filter(
			(option) => option.type !== "blank" && option.type !== "abstain",
		)
		.map((option) => ({
			id: option.id,
			value: option.value ? option.value : option.candidate.id,
			display_name: getOptionName(option),
		}));
});

const blankVoteOption = computed(() => {
	return props.ballot.vote_options.find((option) => option.type === "blank");
});

const abstainVoteOption = computed(() => {
	return props.ballot.vote_options.find(
		(option) => option.type === "abstain",
	);
});

const selectedOptions = computed(() => {
	return voteOptions.value.filter(
		(option) =>
			option.id !== blankVoteOption.id &&
			option.id !== abstainVoteOption.id &&
			form.selected.includes(option.id),
	);
});

const askConfirm = () => {
	if (isSelected(abstainVoteOption.value.id)) {
		form.selected = form.selected.filter(
			(option) => option !== abstainVoteOption.value.id,
		);
	}
	if (props.ballot.max_votes === 1 && form.selected.length === 0) {
		form.selected.push(blankVoteOption.value.id);
	}
	confirmOpen.value = true;
};

const askAbstainConfirm = () => {
	form.selected = [abstainVoteOption.value.id];
	confirmOpen.value = true;
};

const closeConfirm = () => {
	confirmOpen.value = false;
	if (
		isSelected(abstainVoteOption.value.id) ||
		(blankVoteOption.value && isSelected(blankVoteOption.value.id))
	) {
		form.selected = [];
	}
};

const confirmVote = () => {
	if (isSelected(abstainVoteOption.value.id)) {
		form.selected = [abstainVoteOption.value.id];
	} else if (isSelected(blankVoteOption.value.id)) {
		form.selected = [blankVoteOption.value.id];
	}
	form.post(route("vote.ballot.vote", { ballot: ballot }), {
		onSuccess: () => {
			confirmOpen.value = false;
		},
	});
};
</script>

<template>
	<div>
		<h2 class="text-2xl font-bold mb-8 text-center">
			{{ ballot.question }}
		</h2>
		<button
			v-for="option in voteOptions"
			:key="option.id"
			class="w-full h-20 rounded-xl shadow-xl border-gray-400 border bg-gray-600 flex items-center justify-center text-xl font-bold cursor-pointer transition-all"
			v-bind:class="{
				'bg-green-600 scale-95 border-green-400': isSelected(option.id),
			}"
			@click="toggleOption(option.id)"
		>
			<span>{{ option.display_name }}</span>
		</button>
		<div class="mt-8 flex flex-row items-center justify-between space-x-6">
			<button
				class="w-1/2 h-12 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors cursor-pointer disabled:text-red-400 disabled:cursor-not-allowed"
				:disabled="confirmOpen"
				@click="askAbstainConfirm"
			>
				Astieniti
			</button>
			<button
				class="w-1/2 h-12 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors cursor-pointer disabled:bg-gray-600 disabled:cursor-not-allowed"
				:disabled="
					(ballot.type === 'standard' &&
						form.selected.length === 0) ||
					confirmOpen ||
					isSelected(abstainVoteOption.id)
				"
				@click="askConfirm"
			>
				Invia voto
			</button>
		</div>
		<div>
			<TransitionRoot as="template" :show="confirmOpen">
				<Dialog class="relative z-10" @close="closeConfirm">
					<TransitionChild
						as="template"
						enter="ease-out duration-300"
						enter-from="opacity-0"
						enter-to="opacity-100"
						leave="ease-in duration-200"
						leave-from="opacity-100"
						leave-to="opacity-0"
					>
						<div
							class="fixed inset-0 bg-gray-500/75 transition-opacity"
						/>
					</TransitionChild>

					<div class="fixed inset-0 z-10 w-screen overflow-y-auto">
						<div
							class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
						>
							<TransitionChild
								as="template"
								enter="ease-out duration-300"
								enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
								enter-to="opacity-100 translate-y-0 sm:scale-100"
								leave="ease-in duration-200"
								leave-from="opacity-100 translate-y-0 sm:scale-100"
								leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
							>
								<DialogPanel
									class="relative transform overflow-hidden rounded-lg bg-card-background px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
								>
									<div>
										<div class="mt-3 text-center sm:mt-5">
											<DialogTitle
												as="h3"
												class="text-lg font-semibold text-white"
											>
												{{
													isSelected(
														abstainVoteOption?.id,
													)
														? "Conferma Astensione"
														: isSelected(
																	blankVoteOption?.id,
															  )
															? "Conferma Voto Bianco"
															: "Conferma Voto"
												}}
											</DialogTitle>
											<div
												v-if="
													selectedOptions.length > 0
												"
												class="mt-2"
											>
												<p
													v-if="
														selectedOptions.length <
														ballot.max_votes
													"
													class="text-base text-red-400"
												>
													Attenzione: voto parziale.
													Hai ancora voti non
													espressi: hai espresso
													{{ selectedOptions.length }}
													voti su
													{{ ballot.max_votes }}. Sei
													sicuro di voler continuare?
												</p>
												<p
													class="text-base text-gray-100"
												>
													Hai scelto:
												</p>
												<ul class="mt-2 space-y-2">
													<li
														v-for="option in selectedOptions"
														:key="option.id"
														class="text-base text-gray-200"
													>
														{{
															option.display_name
														}}
													</li>
												</ul>
											</div>
											<div
												v-else-if="
													isSelected(
														abstainVoteOption?.id,
													)
												"
											>
												<p
													class="text-base text-gray-100"
												>
													Hai scelto di astenerti.
												</p>
											</div>
											<div
												v-else-if="
													isSelected(
														blankVoteOption?.id,
													)
												"
											>
												<p
													class="text-base text-gray-100"
												>
													Non hai selezionato alcuna
													opzione. Hai scelto di
													votare scheda bianca.
												</p>
											</div>
										</div>
									</div>
									<div
										class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3"
									>
										<button
											type="button"
											class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2 cursor-pointer"
											@click="confirmVote"
										>
											{{
												isSelected(
													abstainVoteOption?.id,
												)
													? "Conferma Astensione"
													: isSelected(
																blankVoteOption?.id,
														  )
														? "Conferma Voto Bianco"
														: "Conferma Voto"
											}}
										</button>
										<button
											type="button"
											class="mt-3 inline-flex w-full justify-center rounded-md bg-gray-300 px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-500 ring-inset hover:bg-gray-200 sm:col-start-1 sm:mt-0 cursor-pointer"
											@click="closeConfirm"
											ref="cancelButtonRef"
										>
											Annulla
										</button>
									</div>
								</DialogPanel>
							</TransitionChild>
						</div>
					</div>
				</Dialog>
			</TransitionRoot>
		</div>
	</div>
</template>
