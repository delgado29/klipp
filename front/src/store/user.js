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

    logout() {
      this.user = null
      this.isAuthenticated = false
    },

    getRoleRedirectPath() {
      if (!this.user || !this.user.role) return '/login'

      switch (this.user.role.name) {
        case 'admin':
          return '/admin/dashboard'
        case 'employee':
          return '/employee/dashboard'
        case 'client':
          return '/client/dashboard'
        default:
          return '/login'
      }
    },
  },
  persist: true,
})