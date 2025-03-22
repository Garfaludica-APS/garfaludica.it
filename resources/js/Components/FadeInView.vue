<script setup lang="ts">
	import { onMounted, ref } from 'vue';

	defineProps({
		speed: {
			type: String,
			default: 'normal',
		},
		delay: {
			type: String,
			default: 'none',
		}
	});

	const target = ref<Element>();
	const isVisible = ref<boolean>(false);

onMounted(() => {
	const observer = new IntersectionObserver(
		([entry]) => {
			isVisible.value = entry.isIntersecting;
			if (entry.isIntersecting)
				observer.unobserve(target.value as Element);
		},
		{
			threshold: 0.5
		}
	);

	observer.observe(target.value as Element);
});
</script>
<template>
	<div ref="target" class="transform-gpu transition-[opacity,translate] ease-in" :class="{ 'duration-700': speed == 'normal', 'duration-500': speed == 'fast', 'duration-1000': speed == 'slow', 'delay-150': delay == 'small', 'delay-300': delay == 'medium', 'delay-500': delay == 'large', 'opacity-100': isVisible, 'translate-none': isVisible, 'opacity-0': !isVisible, 'translate-y-4': !isVisible }">
		<slot />
	</div>
</template>
