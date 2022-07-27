<template>
	<div class="grid justify-items-center space-y-6">
		<Title>Shopping Cart | {{ title }}</Title>
		<div class="text-3xl font-bold">
			Shopping Cart
		</div>
		<div class="w-fit grid md:grid-cols-2 xl:grid-cols-3 gap-6 p-6 border rounded-xl">
			<CartItem v-for="item in cart.value" :key="item.id" :item="item" :show="item.quantity > 0" @total-change="change_total"/>
		</div>
		<div class="w-auto font-bold text-2xl items-center justify-center">
			Total: {{total}} kn
		</div>
		<div class="flex items-center justify-between w-1/2 pb-6">
			<NuxtLink to="/">&larr; Continue Shopping</NuxtLink>
			<ButtonLink to="/order">Order</ButtonLink>
		</div>
	</div>
</template>

<script setup>
	let title = useState('title')

	let cart = reactive({})
	let total = ref(0)
	onMounted(() => {
		if(localStorage.getItem("cart")){
			cart.value = JSON.parse(localStorage.getItem("cart"));
		}
		if(localStorage.getItem("total")){
			total.value = localStorage.getItem("total");
		}
	})
	function change_total(){
		if(localStorage.getItem("cart")){
			cart.value = JSON.parse(localStorage.getItem("cart"));
		}
		if(localStorage.getItem("total")){
			total.value = localStorage.getItem("total");
		}
	}
</script>