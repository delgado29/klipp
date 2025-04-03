<script setup>
import LogoutButton from '@/components/LogoutButton.vue'
</script>

<template>
  <div class="employee-layout">
    <nav class="p-4 bg-blue-100 flex justify-between items-center">
      <h1 class="text-xl font-semibold">Panel de Empleado</h1>
      <LogoutButton />
    </nav>

    <main class="p-4">
      <slot />
    </main>
  </div>
</template>