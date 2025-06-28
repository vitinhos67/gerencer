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
router.beforeEach(async (to, from, next) => {
  // Importar o composable dinamicamente para evitar problemas de inicialização
  const { useAuth } = await import('./composables/useAuth')
  const { isAuthenticated, checkAuth } = useAuth()
  
  if (to.meta.requiresAuth) {
    // Se não estiver autenticado, tentar verificar com o servidor
    if (!isAuthenticated.value) {
      const authenticated = await checkAuth()
      if (!authenticated) {
        next('/login')
        return
      }
    }
  }
  
  // Se estiver na página de login e já autenticado, redirecionar
  if (to.path === '/login' && isAuthenticated.value) {
    next('/admin/dashboard')
    return
  }
  
  next()
})

export default router 