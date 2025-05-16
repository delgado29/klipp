<template>
  <div class="login-container d-flex align-items-center justify-content-center min-vh-100">
    <b-card class="p-4" style="max-width: 400px; width: 100%;" bg-variant="light" border-variant="primary">
      <h2 class="mb-4 text-center">Iniciar sesión</h2>
      <b-form @submit.prevent="login">
        <b-form-group label="Email" label-for="email-input" class="mb-3">
          <b-form-input id="email-input" v-model="form.email" type="email" required />
        </b-form-group>

        <b-form-group label="Contraseña" label-for="password-input" class="mb-3">
          <b-form-input id="password-input" v-model="form.password" type="password" required />
        </b-form-group>

        <b-alert v-if="error" variant="danger" show class="mb-3">
          {{ error }}
        </b-alert>

        <b-button type="submit" variant="primary" block :disabled="loading">
          {{ loading ? 'Ingresando...' : 'Ingresar' }}
        </b-button>

        <p class="mt-3 text-center">
          ¿No tienes cuenta?
          <router-link to="/register">Regístrate aquí</router-link>
        </p>
      </b-form>
    </b-card>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/store/user'
import {
  BCard,
  BForm,
  BFormGroup,
  BFormInput,
  BButton,
  BAlert
} from 'bootstrap-vue-3'

const router = useRouter()
const userStore = useUserStore()

const form = ref({
  email: '',
  password: ''
})
const loading = ref(false)
const error = ref(null)

const login = async () => {
  error.value = null
  loading.value = true
  
  try {
    await userStore.login(form.value)
    console.log('Login successful')
    console.log(userStore.user?.role?.name)
    
    console.log(userStore.getRoleRedirectPath())
    router.push(userStore.getRoleRedirectPath())
    
    
  } catch (err) {
    console.error('Login error:', err)
    error.value = err?.response?.data?.message || 'Error al iniciar sesión'
  } finally {
    loading.value = false
  }
}

/*onMounted(() => {
  if (userStore.isAuthenticated) {
    router.push({ name: 'GuestHome' })
  }
})*/ //verificar si esta autenticado


</script>

<style scoped>
.login-container {
  max-width: 400px;
  width: 100%;
  margin: 0 auto;
  background: rgba(255, 255, 255, 0.9);
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.login-container h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  font-weight: bold;
}

.login-container form > div {
  margin-bottom: 1rem;
}

.login-container button {
  width: 100%;
  padding: 0.75rem;
}

.login-container .error {
  color: #e74c3c;
  margin-bottom: 1rem;
  text-align: center;
}
</style>