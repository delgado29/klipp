<template>
  <div>
    <AppHeader />
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
import { ref } from 'vue'
import { useRouter } from 'vue-router'

import AppHeader from '@/components/guest/AppHeader.vue'
import HeroSection from '@/components/guest/HeroSection.vue'
import BusinessList from '@/components/guest/BusinessList.vue'
import AppFooter from '@/components/guest/AppFooter.vue'

const router = useRouter()

// Datos de ejemplo para categorías y negocios
const categories = ref([
  'Barberos', 'Salón de uñas', 'Peluquería', 'Day SPA',
  'Cejas y pestañas', 'Masaje', 'Cuidado de piel', 'Maquillaje', 'Más...'
])

const businesses = ref([
  {
    id: 1,
    name: 'Barbería El Corte',
    description: 'Especialistas en cortes modernos para caballeros.',
    services: ['Corte de cabello', 'Afeitado clásico'],
  },
  {
    id: 2,
    name: 'Spa Relax',
    description: 'Tu lugar de relajación y bienestar.',
    services: ['Masaje relajante', 'Facial hidratante'],
  },
  {
    id: 3,
    name: 'Glow Nails',
    description: 'Diseños de uñas únicos y personalizados.',
    services: ['Manicura gel', 'Pedicura spa'],
  }
])

function onSearch(query) {
  console.log('Buscar:', query)
  // TODO: implementar búsqueda o filtrado real
}

function onFilterCategory(category) {
  console.log('Filtrar por categoría:', category)
  // TODO: implementar filtrado por categoría
}

function onSelectBusiness(id) {
  // Redirigir a login si no está logueado y luego al negocio
  router.push({ name: 'Login', query: { redirect: `/business/${id}` } })
}
</script>

<style scoped>
</style>