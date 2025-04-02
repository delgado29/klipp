<template>
  <div class="login-container">
    <h2>Iniciar sesión</h2>
    <form @submit.prevent="login">
      <div>
        <label>Email</label>
        <input v-model="form.email" type="email" required />
      </div>
      <div>
        <label>Contraseña</label>
        <input v-model="form.password" type="password" required />
      </div>
      <div v-if="error" class="error">{{ error }}</div>
      <button type="submit" :disabled="loading">
        {{ loading ? "Ingresando..." : "Ingresar" }}
      </button>
    </form>
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { useUserStore } from '@/store/user'
import { ref } from 'vue'

export default {
  name: 'LoginPage',
  setup() {
    const router = useRouter()
    const userStore = useUserStore()

    const form = ref({ email: '', password: '' })
    const loading = ref(false)
    const error = ref(null)

    const login = async () => {
      error.value = null
      loading.value = true
      try {
        await userStore.login(form.value)

        const redirectPath = userStore.getRoleRedirectPath()
        router.push(redirectPath)
      } catch (err) {
        error.value = err?.response?.data?.message || 'Error al iniciar sesión'
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      login,
      error,
      loading
    }
  }
}
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: 40px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

label {
  display: block;
  margin-bottom: 4px;
  font-weight: bold;
}

input {
  width: 100%;
  margin-bottom: 12px;
  padding: 8px;
  box-sizing: border-box;
}

button {
  width: 100%;
  padding: 10px;
}

.error {
  color: red;
  margin-bottom: 12px;
}
</style>