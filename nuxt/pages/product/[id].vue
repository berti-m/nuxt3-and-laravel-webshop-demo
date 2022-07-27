<template>
	<div class="grid grid-cols-5 mb-6" :key="product.id">
		<div class="col-span-5 xl:col-span-2 row-span-6">
			<img :src="useRuntimeConfig().LARAVEL_URL + '/storage/' + product.picture" class="rounded-xl">
		</div>
		<div class="mt-10 xl:mx-6 w-full font-bold text-5xl col-span-5 xl:col-span-3 text-center row-span-1 underline">
			{{product.name}}
		</div>

		<div class="flex p-5 text-center xl: text-left xl:p-0 xl:pl-5 xl:pt-5 m-6 font-normal text-xl col-span-5 xl:col-span-3 items-center justify-center row-span-3 border rounded-xl">
			{{product.description}}
		</div>

		<div class="grid xl:flex xl:pl-5 xl:pt-5 col-span-5 xl:col-span-3 items-center justify-center space-y-6 xl:space-y-0 xl:space-x-12 row-span-1">
			<div class="text-3xl self-center">
				Price: 
				<span class="font-bold underline">
					{{product.price}} kn
				</span>
			</div>

			<div class="flex items-center self-center justify-center">
				<label for="quantity">Quantity:</label>
				<input type="number" name="quantity" class="border ml-3 p-5 w-24 h-3 rounded-xl border-black" v-model="quantity">
			</div>

			<form @submit.prevent="add_to_cart" class="flex items-center justify-center">
				<ButtonSubmit :disabled="processing || quantity > product.number_available || quantity <= 0">Add To Cart</ButtonSubmit>
			</form>
		</div>

		<div class="flex mt-6 w-full font-normal text-md col-span-5 xl:col-span-3 items-center justify-center row-span-1">
			Currently in stock: {{product.number_available}}
		</div>
	</div>
</template>

<script setup>
	console.log(useRuntimeConfig().LARAVEL_URL + '/api/product/' + useRoute().params.id)
	//let { data: product } = await useFetch(useRuntimeConfig().LARAVEL_URL + '/api/product/' + useRoute().params.id)
	let product = await useNuxtApp().$apiFetch('/api/product/' + useRoute().params.id, {
		key: 'productGet'+useRoute().params.id
	})
	let quantity = ref(1)
	let processing = ref(false)

	function add_to_cart(){
		processing.value = true
		
		let cart = {}
		let total = 0
		let available = product.number_available
		available -= quantity.value
		if (localStorage.getItem("cart")){
			cart = JSON.parse(localStorage.getItem("cart"))
		}
		if (localStorage.getItem("total")){
			total = parseFloat(localStorage.getItem("total"));
		}
		let productid = product.id
		if (cart[productid]){
			available -= cart[productid]["quantity"]
		}
		if (available<0 || quantity.value <= 0){
			alert("Not enough products available to fill your order!")
			return processing.value = false
		}
		if(cart[productid]){
			cart[productid]["quantity"] += quantity.value
		} else {
			cart[productid]= { "id": productid, "quantity": quantity.value }
		}
		total += quantity.value * product.price
		localStorage.setItem('cart',JSON.stringify(cart))
		localStorage.setItem('total', round(total))
		return useRouter().push('/cart')
	}
	function round(number){
		return Math.round(number * 100) / 100;
	}
</script>