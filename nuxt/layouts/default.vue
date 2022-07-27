<template>
	<div class="grid space-y-8">
		<Title>{{ title }}</Title>
		<div class="grid space-y-6 sm:space-y-0 sm:flex w-screen p-8 bg-yellow-400 text-black items-center justify-center sm:justify-between sm:justify-items-between text-2xl font-semibold rounded-b-xl">
			<NuxtLink to="/" class="p-3 border-black border-2 rounded-xl hover:bg-yellow-500 flex items-center justify-center">
				<img src="/honey.webp" width="50" class="rounded mr-4">
				OPG Bertetić
			</NuxtLink>

			<div class="grid sm:flex items-center justify-center sm:justify-between gap-y-6 sm:gap-x-6 font-normal">
				<NuxtLink to="/">Home</NuxtLink>
				<NuxtLink to="/about">About</NuxtLink>
				<NuxtLink to="/cart" class="flex items-center justify-center">
					<img src="/shopping-cart.png" width="40">
				</NuxtLink>
				<NuxtLink to="/login">LogIn</NuxtLink>
				<NuxtLink to="/orders">Orders</NuxtLink>
				<NuxtLink to="/logout">LogOut</NuxtLink>
			</div>
		</div>
		<div class="m-8">
			<slot />
		</div>
	</div>
</template>

<style type="text/css">

.router-link-active {
	font-weight: bold;
}

</style>

<script setup>
	let title = useState('title', () => 'OPG Bertetić')
</script>