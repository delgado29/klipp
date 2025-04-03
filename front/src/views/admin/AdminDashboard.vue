<template>
  <div>
  
  </div>
</template>

<script setup>
import { useUserStore } from '@/store/user'
const userStore = useUserStore()

// Check if the user is authenticated when the component is created
userStore.checkAuth()

</script>