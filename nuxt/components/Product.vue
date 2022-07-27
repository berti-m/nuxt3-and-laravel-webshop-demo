<template>
	<button @click.prevent="open" class="grid grid-cols-2 grid-rows-2 gap-3 items-center justify-center border-2 border-black rounded-xl p-3" :class="{
		'bg-yellow-100 hover:bg-yellow-200': props.product.number_available > 0,
		'bg-gray-200 hover:bg-gray-300': props.product.number_available <= 0,
	}">
		<img :src="useRuntimeConfig().LARAVEL_URL + '/storage/' + props.product.picture" class="row-span-2 rounded">
		<div class="font-bold justify-self-center place-self-start text-center text-xl mt-3 underline">
			{{ props.product.name }}
		</div>
		<div class="grid gap-2 font-bold justify-self-center place-self-end mb-3">
			<div class="text-md p-2 border-4 border-double border-black rounded-xl">
				{{props.product.price}} kn
			</div>
			<div class="text-xs font-normal">
				Available: {{props.product.number_available}}
			</div>
			<ButtonLink :to="'/product/'+props.product.id">
				Find Out More
			</ButtonLink>
		</div>
	</button>
</template>

<script setup>
	let props = defineProps({
		product: Object
	})
	function open(){
		useRouter().push('/product/'+props.product.id)
	}
</script>