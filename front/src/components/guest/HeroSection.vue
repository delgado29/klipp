<template>
  <section
    class="hero-section d-flex align-items-center justify-content-center text-white"
    :style="bgStyle"
  >
    <div class="overlay"></div>
    <div class="text-center position-relative">
      <h1 class="display-4 fw-bold">{{ title }}</h1>
      <p class="lead">{{ subtitle }}</p>
      <b-input-group size="lg" class="mx-auto mt-4" style="max-width:500px">
        <b-form-input
          v-model="searchQuery"
          placeholder="Search services or businesses"
          @keyup.enter="emitSearch"
        />
        <b-button @click="emitSearch">Search</b-button>
      </b-input-group>
      <QuickCategories
        :categories="categories"
        @select="onCategorySelect"
        class="mt-4 quick-cats"
      />
    </div>
  </section>
</template>


<style scoped>
.hero-section {
  position: relative;
  height: 80vh;
  background: center/cover no-repeat;
}
.hero-section .overlay {
  position: absolute;
  inset: 0;
  background-color: rgba(0,0,0,0.5);
}
.hero-section .text-center {
  z-index: 1;
}
.quick-cats .btn-link {
  color: white !important;
}
</style>

<script>
import bgImage from '@/assets/image.png';
import QuickCategories from '@/components/guest/QuickCategories.vue';

export default {
  name: 'HeroSection',
  components: { QuickCategories },
  props: {
    title: {
      type: String,
      required: true
    },
    subtitle: {
      type: String,
      required: true
    },
    background: {
      type: String,
      required: true
    },
    categories: {
      type: Array,
      required: true
    }
  },
  emits: ['search', 'select'],
  computed: {
    bgStyle() {
      return {
        backgroundImage: `url(${bgImage})`,
      };
    }
  },
  data() {
    return {
      searchQuery: ''
    };
  },
  methods: {
    emitSearch() {
      this.$emit('search', this.searchQuery);
    },
    onCategorySelect(category) {
      this.$emit('select', category);
    }
  }
};
</script>