<script setup>
import LogoutButton from '@/components/LogoutButton.vue'
</script>

<template>
  <div class="client-layout">
    <nav class="p-4 bg-green-100 flex justify-between items-center">
      <h1 class="text-xl font-semibold">Panel del Cliente</h1>
      <LogoutButton />
    </nav>

    <main class="p-4">
      <slot />
    </main>
  </div>
</template>