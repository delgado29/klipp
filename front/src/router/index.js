import { createRouter, createWebHistory } from 'vue-router'

import AdminLayout from '../layouts/AdminLayout.vue'
import EmployeeLayout from '../layouts/EmployeeLayout.vue'
import ClientLayout from '../layouts/ClientLayout.vue'

import AdminDashboard from '../views/admin/AdminDashboard.vue'
import EmployeeDashboard from '../views/employee/EmployeeDashboard.vue'
import ClientDashboard from '../views/client/ClientDashboard.vue'

import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '/admin',
    component: AdminLayout,
    children: [
      {
        path: '',
        name: 'AdminDashboard',
        component: AdminDashboard
      }
    ]
  },
  {
    path: '/employee',
    component: EmployeeLayout,
    children: [
      {
        path: '',
        name: 'EmployeeDashboard',
        component: EmployeeDashboard
      }
    ]
  },
  {
    path: '/client',
    component: ClientLayout,
    children: [
      {
        path: '',
        name: 'ClientDashboard',
        component: ClientDashboard
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
