<template>
  <b-container fluid>
    <b-row class="gy-4">
      <b-col
        v-for="biz in businesses"
        :key="biz.id"
        cols="12" md="6" lg="4"
      >
        <b-card
          :title="biz.name"
          class="h-100"
        >
          <b-card-text class="mb-2">{{ biz.description }}</b-card-text>
          <p class="mb-1"><strong>Dirección:</strong> {{ biz.address }}</p>
          <p class="mb-2"><strong>Teléfono:</strong> {{ biz.phone }}</p>
          <b-badge
            v-for="(s, idx) in biz.services"
            :key="idx"
            class="me-1"
          >{{ s }}</b-badge>
          <b-button variant="primary" @click="$emit('select', biz)">Agendar</b-button>

        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>


<script>
export default {
  name: 'BusinessList',
  props: {
    businesses: {
      type: Array,
      required: true
    }
  },
  emits: ['select']
};
</script>

<style scoped>
.cursor-pointer { cursor: pointer; }
</style>