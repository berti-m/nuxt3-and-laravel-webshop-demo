<template>
	<div class="flex items-center justify-between w-full space-x-6">
		<label :for="props.name">{{props.name}}:</label>
		<slot/>
	</div>
	<div class="text-xs grid justify-center items-center w-full gap-2 font-bold text-red-600">
		<span v-for="error in errors" v-text="error" />
	</div>
</template>

<script setup>
	let props = defineProps({
		name: String,
		errors: Array,
	})
</script>