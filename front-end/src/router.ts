import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import HomeComponent from './views/admin/HomeComponent.vue'
import AboutComponent from './views/admin/AboutComponent.vue'
import LoginComponent from './views/admin/LoginComponent.vue'

const routes: RouteRecordRaw[] = [
  { path: '/', component: HomeComponent },
  { path: '/about', component: AboutComponent },
  { path: '/login', component: LoginComponent},
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router 