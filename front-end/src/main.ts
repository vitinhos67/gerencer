import { createApp } from 'vue'
import App from './App.vue'
import 'vuetify/dist/vuetify.min.css' 
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import router from './router'

import 'vuetify/styles'

const vuetify = createVuetify({
  components,
  directives,
})

const app = createApp(App)

app.use(vuetify)
app.use(router)
app.mount('#app')
