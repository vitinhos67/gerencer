import { createRouter, createWebHistory } from 'vue-router'
import HomeComponent from './views/HomeComponent.vue'
import AboutComponent from './views/AboutComponent.vue'

const routes = [
  { path: '/', component: HomeComponent },
  { path: '/about', component: AboutComponent },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router 