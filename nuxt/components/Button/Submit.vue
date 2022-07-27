<template>
	<button :disabled="props.disabled" :class="{
		'bg-gray-200': props.disabled,
		'bg-blue-300 hover:bg-blue-700 hover:text-white': !props.disabled
	}" v-if="!confirm" 
	class="p-3 rounded-xl border-2 border-black text-black font-bold text-md" 
	@click.prevent="confirm = true">
		<slot />
	</button>
	<div v-if="confirm" class="flex items-center justify-center gap-6 font-bold">
		Confirm:
		<button :disabled="props.disabled" :class="{
			'bg-gray-200': props.disabled,
			'bg-red-300 hover:bg-red-700 hover:text-white': !props.disabled
		}" class="p-3 rounded-xl border-2 border-black text-black font-bold text-md" @click.prevent="confirm = false">
			No
		</button>
		<button :disabled="props.disabled" :class="{
			'bg-gray-200': props.disabled,
			'bg-green-300 hover:bg-green-700 hover:text-white': !props.disabled
		}" type="submit" class="p-3 rounded-xl border-2 border-black text-black font-bold text-md">
			Yes
		</button>
	</div>
</template>

<script setup>
	let confirm = ref(false)
	let props = defineProps({
		disabled: {
			type: Boolean,
			default: false
		}
	})

</script>