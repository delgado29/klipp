import { defineStore } from 'pinia'
import axios from 'axios'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    isAuthenticated: false,
    token: null
  }),

  actions: {
    async login(credentials) {
      console.log('Login credentials:', credentials)
      const response = await axios.post('/api/login', credentials)
      console.log('Login response:', response.data)
      this.user = response.data.user
      this.token = response.data.token
      this.isAuthenticated = true
    },

    async logout() {
      this.user = null
      this.token = null
      this.isAuthenticated = false
      window.location.href = '/'
    },

    //estoy autenticado?
    async checkAuth() {
      try {
        const response = await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.user = response.data
        this.isAuthenticated = true
        console.log('✅ Usuario autenticado:', response.data)
      } catch (error) {
        console.error('❌ No estás autenticado:', error.response?.status, error.response?.data)
        this.user = null
        this.token = null
        this.isAuthenticated = false
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