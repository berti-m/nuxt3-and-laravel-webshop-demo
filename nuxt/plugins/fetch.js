import {defineNuxtPlugin} from "#app";
import Cookies from "js-cookie";

export default defineNuxtPlugin(nuxtApp => {
  nuxtApp.provide('apiFetch', 
    $fetch.create({
      baseURL: useRuntimeConfig().LARAVEL_URL,
      credentials: "include",
      headers: {
        "Accept": "application/json",
        "x-xsrf-token": Cookies.get("XSRF-TOKEN")
      }
    })
  );
});