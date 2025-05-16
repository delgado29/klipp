import { useUserStore } from '@/store/user'
import { createRouter, createWebHistory } from 'vue-router'


import AdminDashboard from '../views/admin/AdminDashboard.vue'
import EmployeeDashboard from '../views/employee/EmployeeDashboard.vue'
import ClientDashboard from '../views/client/ClientDashboard.vue'

import LoginPage from '../views/auth/LoginPage.vue'
import RegisterPage from '../views/auth/RegisterPage.vue'
import GuestHomePage from '@/views/guest/GuestHomePage.vue'


const routes = [
  
  {
    path: '/',
    name: 'GuestHome',
    component: GuestHomePage,
    meta: { requiresGuest: true }
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage,
    meta: { requiresGuest: true }
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterPage,
    meta: { requiresGuest: true }
  },
  {
    path: '/admin',
    name: 'AdminDashboard',
    component: AdminDashboard
  },
  {
    path: '/employee',
    name: 'EmployeeDashboard',
    component: EmployeeDashboard
  },
  {
    path: '/client',
    name: 'ClientDashboard',
    component: ClientDashboard
  },
  {
    path: '/business/:id/book',
    name: 'BusinessBooking',
    component: () => import('@/views/booking/BusinessBooking.vue'),
    props: true
  },
  {
    path: '/terms',
    name: 'Terms',
    component: () => import('@/views/TermsPage.vue') 
  },
  {
    path: '/privacy',
    name: 'Privacy',
    component: () => import('@/views/PrivacyPage.vue')
  },
  {
    path: '/help',
    name: 'Help',
    component: () => import('@/views/HelpPage.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})


router.beforeEach((to, from, next) => {
  const userStore = useUserStore()

  const protectedPrefixes = {
    '/admin': 'admin',
    '/employee': 'employee',
    '/client': 'client'
  }

  const currentPrefix = '/' + to.path.split('/')[1] || '/'
  const expectedRole = protectedPrefixes[currentPrefix]

  if (expectedRole) {
    if (!userStore.isAuthenticated) {
      return next({ name: 'Login' })
    }
    if (userStore.user?.role?.name !== expectedRole) {
      return next({ name: 'Login' })
    }
  }

  if (to.meta.requiresGuest && userStore.isAuthenticated && userStore.user?.role?.name) {
    return next(userStore.getRoleRedirectPath())
  }

  next()
})

export default router
