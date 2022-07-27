<template>
	<NuxtLink :to="props.to" class="p-3 rounded-xl border-2 border-black bg-blue-300 text-black hover:bg-blue-700 hover:text-white font-bold text-md">
		<slot />
	</NuxtLink>
</template>

<script setup>
	let props = defineProps({
		to: String
	})
</script>