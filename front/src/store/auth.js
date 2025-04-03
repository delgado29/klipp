
import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    role: null,
    loading: false,
    error: null
  }),

  actions: {
    async login(credentials) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', credentials, {
          withCredentials: true
        })

        this.token = response.data.token || null
        this.user = response.data.user || null
        this.role = response.data.user?.role?.name || null
      } catch (err) {
        this.error = err.response?.data?.message || 'Error al iniciar sesión'
      } finally {
        this.loading = false
      }
    },

    async logout() {
      try {
        await axios.post('http://127.0.0.1:8000/api/logout', {}, { withCredentials: true })
      } catch (err) {
        // Ignore
      }
      this.user = null
      this.token = null
      this.role = null
    },

    async fetchUser() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/user', {
          withCredentials: true
        })
        this.user = response.data
        this.role = response.data.role?.name || null
      } catch (err) {
        this.user = null
        this.token = null
        this.role = null
      }
    }
  }
})