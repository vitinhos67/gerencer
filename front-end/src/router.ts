import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import HomeComponent from './views/admin/HomeComponent.vue'
import AboutComponent from './views/admin/AboutComponent.vue'
import LoginComponent from './views/admin/LoginComponent.vue'
import DashboardComponent from './views/admin/DashboardComponent.vue'
import DashboardHomeComponent from './views/admin/DashboardHomeComponent.vue'

const routes: RouteRecordRaw[] = [
  { path: '/', component: HomeComponent },
  { path: '/about', component: AboutComponent },
  { path: '/login', component: LoginComponent},
  {
    path: '/admin',
    component: DashboardComponent,
    meta: { requiresAuth: true },
    children: [
      {
        path: 'dashboard',
        component: DashboardHomeComponent
      },
      {
        path: 'users',
        component: () => import('./views/admin/UsersComponent.vue')
      },
      {
        path: 'settings',
        component: () => import('./views/admin/SettingsComponent.vue')
      },
      {
        path: 'reports',
        component: () => import('./views/admin/ReportsComponent.vue')
      },
      {
        path: '',
        redirect: '/admin/dashboard'
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Guarda de rota para verificar autenticação
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  
  if (to.meta.requiresAuth && !token) {
    // Redirecionar para login se não estiver autenticado
    next('/login')
  } else if (to.path === '/login' && token) {
    // Redirecionar para dashboard se já estiver autenticado
    next('/admin/dashboard')
  } else {
    next()
  }
})

export default router 