import { defineStore } from 'pinia'
import axios from 'axios'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    isAuthenticated: false,
  }),

  actions: {
    async login(credentials) {
      await axios.get('/sanctum/csrf-cookie')
      const response = await axios.post('/api/login', credentials)
      this.user = response.data.user
      this.isAuthenticated = true
    },

    async logout() {
      if (!this.user) {
        this.isAuthenticated = false
        return
      }
    
      try {
        await axios.post('/api/logout', {}, { withCredentials: true })
        this.user = null
        this.isAuthenticated = false
    
        // Redirigir al login
        window.location.href = '/login'
      } catch (error) {
        console.error('Error during logout:', error)
      }
    },

    //estoy autenticado?
    async checkAuth() {
      try {
        const response = await axios.get('/api/user', { withCredentials: true })
        console.log('✅ Usuario autenticado:', response.data)
      } catch (error) {
        console.error('❌ No estás autenticado:', error.response?.status, error.response?.data)
      }
    },

    getRoleRedirectPath() {
      if (!this.user || !this.user.role) return '/login'

      switch (this.user.role.name) {
        case 'admin':
          return '/admin'
        case 'employee':
          return '/employee'
        case 'client':
          return '/client'
        default:
          return '/login'
      }
    },
    
  },
  persist: true,
})