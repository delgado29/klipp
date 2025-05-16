<template>
  <div>
    <AppHeader>
      <template #auth-buttons>
        <div class="d-flex align-items-center gap-2">
          <span class="text-white me-2">Hola, {{ userName }}</span>
          <router-link to="/client" class="btn btn-outline-light btn-sm">Inicio</router-link>
          <router-link to="/client/profile" class="btn btn-outline-light btn-sm">Perfil</router-link>
          <router-link to="/client/history" class="btn btn-outline-light btn-sm">Historial</router-link>
          <b-button variant="outline-light" size="sm" class="ms-2" @click="logout">
            Cerrar sesión
          </b-button>
        </div>
      </template>
    </AppHeader>
    <main class="mt-0 pt-0">
      <HeroSection
        :categories="categories"
        title="Be brave"
        subtitle="Descubre y reserva profesionales de belleza y bienestar cerca de ti."
        background="@/assets/image.png"
        @search="onSearch"
        @select="onFilterCategory"
      />
      <section class="py-5">
        <h2 class="text-center mb-4">Negocios recomendados</h2>
        <BusinessList
          :businesses="businesses"
          @select="onSelectBusiness"
        />
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

import AppHeader from '@/components/guest/AppHeader.vue'
import HeroSection from '@/components/guest/HeroSection.vue'
import BusinessList from '@/components/guest/BusinessList.vue'
import AppFooter from '@/components/guest/AppFooter.vue'

import { useUserStore } from '@/store/user'

const userStore = useUserStore()

const userName = computed(() => userStore.user?.name || 'Usuario')

const logout = async () => {
  await userStore.logout() // borra el token del store
  router.push('/')
}

const router = useRouter()

// Datos de ejemplo para categorías y negocios
const categories = ref([
  'Barberos', 'Salón de uñas', 'Peluquería', 'Day SPA',
  'Cejas y pestañas', 'Masaje', 'Cuidado de piel', 'Maquillaje', 'Más...'
])

const businesses = ref([])

const fetchBusinesses = async () => {
  try {
    console.log('Token usado:', userStore.token)
    console.log('Negocios:', businesses.value)
    
    const response = await axios.get('/api/businesses', {
  headers: {
    Authorization: `Bearer ${userStore.token}`
  }
})
    businesses.value = response.data
  } catch (error) {
    console.error('Error al cargar negocios:', error)
  }
}

onMounted(() => {
  fetchBusinesses()
})

function onSearch(query) {
  console.log('Buscar:', query)
  // TODO: implementar búsqueda o filtrado real
}

function onFilterCategory(category) {
  console.log('Filtrar por categoría:', category)
  // TODO: implementar filtrado por categoría
}

function onSelectBusiness(business) {
  router.push({ name: 'BusinessBooking', params: { id: business.id } })
}
</script>

<style scoped>
</style>