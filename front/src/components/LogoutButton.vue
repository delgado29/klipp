<template>
  <button @click="logout" type="button" aria-label="Cerrar sesión" class="bg-red-500 px-4 py-1 rounded hover:bg-red-600 transition text-white font-semibold">
    Cerrar sesión
  </button>
</template>

<script setup>
import { useUserStore } from '@/store/user'
import { useRouter } from 'vue-router'

const userStore = useUserStore()
const router = useRouter()

const logout = async () => {
  await userStore.logout() // borra el token del store
  router.push('/login')
}
</script>

<style scoped>
button {
  font-weight: 600;
}
</style>