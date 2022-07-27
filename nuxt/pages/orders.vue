<template>
	<div class="grid w-auto grid-cols-1 items-center justify-center gap-6">
		<Title>Orders | {{ title }}</Title>
		<div class="loader" v-if="orders == null"></div>
		<div v-else class="flex gap-6 items-center justify-between min-w-full p-3 bg-yellow-100 rounded-xl" v-for="order in orders" :key="order.id">
			<span class="font-bold">
				Order: {{order.id}}
			</span>
			<span>
				Total: {{order.total}} kn
			</span>
			<span>
				Ordered: {{order.created_at}}
			</span>
			<ButtonLink :to="'/order/'+order.id">Open</ButtonLink>
		</div>
	</div>
</template>

<script setup>
	let title = useState('title')

	let { data:orders, error } = await useAsyncData('orders'+Date.now(), () => useNuxtApp().$apiFetch('/api/orders', {
		method: "GET"
	}))
	

	
</script>
<style type="text/css">
  .loader {
    width: 32px;
    height: 32px;
    border: 3px solid #000;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 
</style>