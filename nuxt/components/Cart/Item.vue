<template>
	<template v-if="show">
	<div v-if="pending" class="flex p-2 border border-gray-600 rounded text-sm font-semibold items-center justify-between bg-gray-100 mb-4 text-xl">
		Loading...
	</div>
	<div v-else class="grid 2xl:grid-cols-2 p-2 border border-gray-600 rounded text-sm font-semibold items-center justify-center bg-gray-100 mb-4">
		<NuxtLink :to="'/product/'+product.id" class="text-lg underline hover:text-blue-800 text-center">
			{{ product.name }}
		</NuxtLink>

		<div class="flex items-center justify-center space-x-6 mt-6 2xl:mt-0">
			<div class="grid items-center justify-items-center">
				<div>
					×<input v-if="!locked" type="number" name="quantity" class="border ml-3 p-5 w-24 h-3 rounded-xl border-black" v-model="quantity">
					<span v-else>
						{{quantity}}
					</span>
				</div>
				<div>
					{{ round(product.price * quantity) }} kn
				</div>
			</div>
			<img v-if="product.picture != ''" :src="useRuntimeConfig().LARAVEL_URL + '/storage/' + product.picture" class="rounded max-h-24">
		</div>
	</div>
	</template>
</template>

<script setup>
	let emit = defineEmits(['total-change'])
	let props = defineProps({
		item: Object,
		show: Boolean,
		locked: {
			type: Boolean,
			default: false
		}
	})
	let quantity = ref(props.item.quantity)
	let product = ref({})
	let pending = ref(true)

	useNuxtApp().$apiFetch('/api/product/' + props.item.id, {
		key: 'cartProductNo'+String(props.item.id)
	}).then(
	  function(result) { 
	  	product.value = result;
	  	pending.value = false;
	  }
	);

	watch(quantity, change_quantity)

	//console.log(product)

	//product.then(res => console.log(res))
	//change_quantity(quantity.value, quantity.value)


	async function change_quantity(newQuant, oldQuant){
		let cart = JSON.parse(localStorage.getItem("cart"));
		let total = parseFloat(localStorage.getItem("total"));
		cart[props.item.id]["quantity"] = Math.min(newQuant, product.value.number_available);
		quantity.value=Math.min(newQuant, product.value.number_available);
		total += (newQuant - oldQuant) * product.value.price;
		localStorage.setItem('cart',JSON.stringify(cart));
		localStorage.setItem('total', round(total));
		emit('total-change');
	}
	function round(number){
		return Math.round(number * 100) / 100;
	}
</script>