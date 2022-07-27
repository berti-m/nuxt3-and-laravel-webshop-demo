<template>
	<div class="flex w-auto items-center justify-center">
		<form @submit.prevent="login" class="grid gap-6 justify-center p-4 border rounded-xl">
			<FormInput name="Email" :errors="bazinga.email">
				<input type="email" name="Email" class="p-3 border rounded-xl" v-model="data.email">
			</FormInput>
			<FormInput name="Password" :errors="bazinga.password">
				<input type="password" name="Password" class="p-3 border rounded-xl" v-model="data.password">
			</FormInput>
			<ButtonSubmit>Login</ButtonSubmit>
		</form>
	</div>
</template>

<script setup>
	await useNuxtApp().$apiFetch('/sanctum/csrf-cookie', {
			method: "GET",
	})

	let bazinga = ref({})
	let data = reactive({
		email: "",
		password: "",
	})
	async function login(){
		const { data:p, error } = await useAsyncData('login'+Date.now(), () => useNuxtApp().$apiFetch('/api/login', {
			method: "POST",
			body: data,
		}))
		console.log(p, error)
		if (p.value){
			console.log('User logged in!')
			useRouter().push('/')
		}
		else{
			bazinga.value = error.value.data.errors
		}
	}
</script>