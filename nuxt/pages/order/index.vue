<template>
	<div class="grid grid-cols-1 lg:grid-cols-2 items-center justify-items-center gap-6">
		<Title>Order | {{ title }}</Title>
		<div class="p-6 lg:col-start-2 border rounded-xl w-fit">
			<CartItem v-for="item in cart.value" :key="item.id" :item="item" :show="item.quantity > 0" :locked="true"/>
			<div class="flex items-center justify-end">
				Total: {{total}} kn
			</div>
		</div>
		<form @submit.prevent="send_order" class="grid items-center lg:row-start-1 justify-items-start gap-6 p-6 border rounded w-min">
			<FormInput name="Name" :errors="bazinga.name">
				<input type="text" class="p-3 border rounded" name="Name" v-model="data.name">
			</FormInput>

			<FormInput name="Surname" :errors="bazinga.surname">
				<input type="text" class="p-3 border rounded" name="Surname" v-model="data.surname">
			</FormInput>
			
			<FormInput name="Email" :errors="bazinga.email">
				<input type="text" class="p-3 border rounded" name="Email" v-model="data.email">
			</FormInput>

			<FormInput name="Address" :errors="bazinga.address">
				<input type="text" class="p-3 border rounded" name="Address" v-model="data.address">
			</FormInput>

			<FormInput name="Town" :errors="bazinga.town">
				<input type="text" class="p-3 border rounded" name="Town" v-model="data.town">
			</FormInput>

			<FormInput name="Postal Code" :errors="bazinga.postal_code">
				<input type="text" class="p-3 border rounded" name="Postal Code" v-model="data.postal_code">
			</FormInput>

			<FormInput name="Country" :errors="bazinga.country">
				<input type="text" class="p-3 border rounded" name="Country" v-model="data.country">
			</FormInput>
			
			<FormInput name="Additional data" :errors="bazinga.additional_data">
				<textarea class="p-3 border rounded w-full" name="Additional data" placeholder="Additional Data" v-model="data.additional_data"></textarea>
			</FormInput>

			<div class="flex items-center justify-center w-full">
				<ButtonSubmit>Order</ButtonSubmit>
			</div>
		</form>
	</div>
</template>

<script setup>
	let title = useState('title')

	let data = reactive({
		name: "",
		surname: "",
		email: "",
		address: "",
		town: "",
		postal_code: "",
		country: "",
		additional_data: ""
	})

	let cart = reactive({})
	let bazinga = ref({})
	let total = ref(0)

	onMounted(() => {
		if(localStorage.getItem("cart")){
			cart.value = JSON.parse(localStorage.getItem("cart"));
		}
		if(localStorage.getItem("total")){
			total.value = localStorage.getItem("total");
		}
	})
	async function send_order(){
		data['products'] = JSON.stringify(cart.value)

		
		const { data:p, error } = await useAsyncData('order'+Date.now(), () => useNuxtApp().$apiFetch('/api/order', {
			method: "POST",
			body: data,
		}))

		if (p.value){
			localStorage.removeItem("cart")
			localStorage.removeItem("total")
			alert("Your order has been successfully submitted! You'll be redirected to the home page")
			data.value = {
				name: "",
				surname: "",
				email: "",
				address: "",
				town: "",
				postal_code: "",
				country: "",
				additional_data: ""
			}
			useRouter().push('/')
		} else {
			bazinga.value = error.value.data.errors
		}
	}
</script>