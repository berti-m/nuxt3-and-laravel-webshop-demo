<template>
	<div class="flex w-auto items-center justify-center">
		<form @submit.prevent="logout" class="grid gap-6 justify-center p-4 border rounded-xl">
			<ButtonSubmit>Logout</ButtonSubmit>
			<div>
				{{errors}}
			</div>
		</form>
	</div>
</template>

<script setup>
  	let errors = ref("")
	async function logout(){
		try{
			await useNuxtApp().$apiFetch('/api/logout', {
				method: "POST",
			})
			console.log('User logged out!')
			await useNuxtApp().$apiFetch('/sanctum/csrf-cookie', {
					method: "GET",
			})
			window.location.href = "/";
			//useRouter().push('/')
		} catch(error){
			console.log(error)
			errors.value = error
		}
	}
</script>