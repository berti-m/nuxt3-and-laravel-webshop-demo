<template>
  <div>
    <div class="grid items-center grid-cols-3 justify-center rounded-xl mb-6 border p-4 w-auto">
      <label for="search" class="mr-2 justify-self-end">Search:</label>
      <input type="text" name="search" class="p-3 border rounded-xl mr-2" v-model="search">
      <span v-if="loading" class="loader justify-self-start"></span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 w-full gap-6 mb-6">
      <Product v-for="product in products" :key="product.id" :product="product"/>
    </div>
  </div>
</template>

<script setup>
  import debounce from "lodash.debounce"

  let search = ref("")
  let loading = ref(false)

  let products = ref()
  products.value = await useNuxtApp().$apiFetch('/api/products')

  watch(search, debounce(async function(newSearch) {
    //console.log()
    loading.value=true;
    products.value = await req(newSearch);
    loading.value=false;
  }, 500))

  async function req(searchvalue){
    const data = await useNuxtApp().$apiFetch('/api/products', {
      params:{
        search: searchvalue,
      },
      key: 'search'+Math.round(+new Date()/1000),
    });
    return data;
  }
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