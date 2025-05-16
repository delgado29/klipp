<template>
  <b-container fluid class="py-3">
    <b-row no-gutters class="overflow-auto flex-nowrap">
      <b-col
        v-for="(cat, i) in categories"
        :key="i"
        class="flex-shrink-0 px-2"
        style="min-width: max-content"
      >
        <b-button variant="outline-light" size="sm" pill class="text-white" @click="$emit('select', cat)">
          {{ cat }}
        </b-button>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  name: 'QuickCategories',
  props: {
    categories: {
      type: Array,
      required: true
    }
  },
  emits: ['select']
};
</script>