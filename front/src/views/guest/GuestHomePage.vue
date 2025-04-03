<template>
  <div>
    <!-- 1. Header fijo -->
    <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center p-4 bg-black bg-opacity-70 text-white shadow-md">
      <h1 class="text-2xl font-bold">klipp</h1>
      <div class="flex items-center space-x-4">
        <router-link to="/login" class="hover:underline">Iniciar sesión</router-link>
        <router-link to="/register" class="hover:underline">Registrarse</router-link>
        <button class="bg-white text-black px-4 py-1 rounded hover:bg-gray-200">Publicar negocio</button>
      </div>
    </header>

    <!-- 2. Hero con fondo imagen -->
    <section class="h-screen flex flex-col justify-center items-center text-white text-center bg-cover bg-center relative" style="background-image: url('/hero-bg.jpg');">
      <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>
      <div class="relative z-10 max-w-xl px-4">
        <h2 class="text-5xl font-bold mb-4">Be brave</h2>
        <p class="text-lg mb-6">Descubre y reserva profesionales de belleza y bienestar cerca de ti.</p>
        <input type="text" placeholder="Buscar servicios o negocios" class="w-full px-6 py-3 rounded-full text-black shadow-lg" />
      </div>
    </section>

    <!-- 3. Categorías rápidas -->
    <section class="flex flex-wrap justify-center gap-4 py-6 px-4 bg-white shadow-sm sticky top-16 z-40">
      <span v-for="cat in categories" :key="cat" class="cursor-pointer hover:underline text-sm font-medium">
        {{ cat }}
      </span>
    </section>

    <!-- 4. Listado de negocios -->
    <section class="py-16 px-6 bg-gray-100">
      <h3 class="text-3xl font-semibold text-center mb-10">Negocios recomendados</h3>
      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="business in businesses" :key="business.id" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
          <h4 class="text-xl font-bold mb-2">{{ business.name }}</h4>
          <p class="text-gray-600 mb-3">{{ business.description }}</p>
          <ul class="text-sm text-gray-500 mb-3">
            <li v-for="service in business.services.slice(0, 2)" :key="service.id">- {{ service.name }}</li>
          </ul>
          <router-link to="/login" class="text-blue-600 hover:underline text-sm">Ver más / Agendar</router-link>
        </div>
      </div>
    </section>

    <!-- 5. Footer -->
    <footer class="text-center py-6 text-sm text-gray-500 bg-white">
      © 2025 klipp. Todos los derechos reservados.
    </footer>
  </div>
</template>

<script setup>
const categories = [
  'Barberos', 'Salón de uñas', 'Peluquería', 'Day SPA',
  'Cejas y pestañas', 'Masaje', 'Cuidado para la piel', 'Maquillaje', 'Más...'
]

const businesses = [
  {
    id: 1,
    name: 'Barbería El Corte',
    description: 'Especialistas en cortes modernos para caballeros.',
    services: [
      { id: 1, name: 'Corte de cabello' },
      { id: 2, name: 'Afeitado clásico' },
    ],
  },
  {
    id: 2,
    name: 'Spa Relax',
    description: 'Tu lugar de relajación y bienestar.',
    services: [
      { id: 3, name: 'Masaje relajante' },
      { id: 4, name: 'Facial hidratante' },
    ],
  },
  {
    id: 3,
    name: 'Glow Nails',
    description: 'Diseños de uñas únicos y personalizados.',
    services: [
      { id: 5, name: 'Manicura gel' },
      { id: 6, name: 'Pedicura spa' },
    ],
  }
]
</script>

<style scoped>
/* Usa tu imagen real en /public/hero-bg.jpg */
</style>