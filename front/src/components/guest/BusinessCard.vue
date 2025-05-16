<template>
    <b-card class="mb-4" :title="name">
      <p class="mb-2">{{ description }}</p>
      <p class="mb-1"><strong>Dirección:</strong> {{ address }}</p>
      <p class="mb-2"><strong>Teléfono:</strong> {{ phone }}</p>
      <ul class="mb-3" v-if="services.length">
        <li v-for="(service, index) in services" :key="index">{{ service }}</li>
      </ul>
      <b-button variant="primary" @click="$emit('select')">Agendar</b-button>
    </b-card>
  </template>
  
  <script>
  export default {
    name: 'BusinessCard',
    props: {
      name: {
        type: String,
        required: true
      },
      description: {
        type: String,
        default: ''
      },
      address: {
        type: String,
        default: ''
      },
      phone: {
        type: String,
        default: ''
      },
      services: {
        type: Array,
        default: () => []
      }
    }
  }
  </script>