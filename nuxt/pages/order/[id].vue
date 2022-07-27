<template>
	<div>
		<NuxtLink to="/orders">&larr; Orders</NuxtLink>
		<div class="w-auto grid md:grid-cols-2 xl:grid-cols-3 gap-6 p-6 border rounded-xl">
			<CartItem v-for="product in order.products" :key="product.id" :item="product" :show="true" :locked="true" />
		</div>
		<div class="flex items-center mt-4 text-xl justify-center">
			Total: {{order.total}} kn
		</div>
	</div>
</template>

<script setup>
	//let { data: product } = await useFetch(useRuntimeConfig().LARAVEL_URL + '/api/product/' + useRoute().params.id)
	let order = await useNuxtApp().$apiFetch('/api/order/' + useRoute().params.id, {
		key: 'orderGet'+useRoute().params.id+'time'+Date.now()
	})

</script>