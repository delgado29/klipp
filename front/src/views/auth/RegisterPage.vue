<template>
  <b-container
    fluid
    class="d-flex align-items-center justify-content-center min-vh-100 register-container"
  >
    <b-card class="p-4" style="max-width: 400px; width: 100%;" bg-variant="light" border-variant="primary">
      <h2 class="mb-4 text-center">Registrarse</h2>
      <b-form @submit.prevent="register">
        <b-form-group label="Nombre" label-for="name-input" class="mb-3">
          <b-form-input
            id="name-input"
            v-model="form.name"
            type="text"
            required
          />
        </b-form-group>
        <b-form-group label="Email" label-for="email-input" class="mb-3">
          <b-form-input
            id="email-input"
            v-model="form.email"
            type="email"
            required
          />
        </b-form-group>
        <b-form-group label="Contraseña" label-for="password-input" class="mb-3">
          <b-form-input
            id="password-input"
            v-model="form.password"
            type="password"
            required
          />
        </b-form-group>
        <b-form-group label="Confirmar contraseña" label-for="password-confirm-input" class="mb-3">
          <b-form-input
            id="password-confirm-input"
            v-model="form.password_confirmation"
            type="password"
            required
          />
        </b-form-group>
        <b-alert v-if="error" variant="danger" show class="mb-3">
          {{ error }}
        </b-alert>
        <b-button type="submit" variant="primary" block :disabled="loading">
          {{ loading ? 'Registrando...' : 'Registrarse' }}
        </b-button>
        <b-button variant="link" block class="mt-2" to="/login">
          Ya tengo cuenta, iniciar sesión
        </b-button>
      </b-form>
    </b-card>
  </b-container>
</template>

<script>
import { useRouter } from 'vue-router'
import { ref } from 'vue'
import axios from 'axios'
import {
  BContainer,
  BCard,
  BForm,
  BFormGroup,
  BFormInput,
  BButton,
  BAlert
} from 'bootstrap-vue-3'

export default {
  name: 'RegisterPage',
  components: {
    BContainer,
    BCard,
    BForm,
    BFormGroup,
    BFormInput,
    BButton,
    BAlert
  },
  setup() {
    const router = useRouter()
    const form = ref({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
    const loading = ref(false)
    const error = ref(null)

    async function register() {
      loading.value = true
      error.value = null
      try {
        // Get CSRF cookie for Sanctum
        await axios.get('/sanctum/csrf-cookie')
        await axios.post('/api/register', form.value)
        router.push({ name: 'home' })
      } catch (err) {
        if (err.response?.data?.errors) {
          // Laravel validation errors
          error.value = Object.values(err.response.data.errors).flat().join(' ')
        } else {
          error.value = err.response?.data?.message || 'Error al registrarse'
        }
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      loading,
      error,
      register
    }
  }
}
</script>

<style scoped>
.register-container {
  background: rgba(255, 255, 255, 0.9);
}
</style>