<script setup>
import LogoutButton from '@/components/LogoutButton.vue'
</script>

<template>
  <div class="admin-layout">
    <!-- Tu menú o navbar -->
    <nav class="p-4 bg-gray-100 flex justify-between items-center">
      <h1 class="text-xl font-semibold">Panel de Administrador</h1>
      <LogoutButton />
    </nav>

    <!-- Contenido -->
    <main class="p-4">
      <slot />
    </main>
  </div>
</template>