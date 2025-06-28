
<template>
  <v-app-bar
    color="#fafafa"
    elevate-on-scroll
    flat
    app
    class="navbar"
  >
    <v-container class="d-flex align-center justify-space-between px-0">
      <!-- Logo ou Título -->
      <div class="d-flex align-center">
        <v-icon color="#ff6b35" size="32">mdi-storefront</v-icon>
        <span class="navbar-title ml-2">Gerencer</span>
      </div>

      <!-- Links principais (desktop) -->
      <div class="d-none d-md-flex align-center gap-4">
        <v-btn variant="text" to="/">Home</v-btn>
        <v-btn variant="text" to="/about">Sobre</v-btn>
        <v-btn variant="text" to="/contato">Contato</v-btn>
        <v-btn
          class="ml-2 franqueado-btn"
          color="orange"
          variant="elevated"
          style="font-weight: bold;"
        >
          Seja um franqueado
        </v-btn>
        <v-btn class="ml-2" color="primary" variant="outlined">Login</v-btn>
      </div>

      <!-- Menu hamburguer (mobile) -->
      <v-menu
        class="d-md-none"
        offset-y
        left
      >
        <template #activator="{ props }">
          <v-btn icon v-bind="props">
            <v-icon>mdi-menu</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item to="/">
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item>
          <v-list-item to="/about">
            <v-list-item-title>Sobre</v-list-item-title>
          </v-list-item>
          <v-list-item to="/contato">
            <v-list-item-title>Contato</v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-btn block color="orange" class="franqueado-btn">Seja um franqueado</v-btn>
          </v-list-item>
          <v-list-item>
            <v-btn block color="primary" variant="outlined">Login</v-btn>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-container>
  </v-app-bar>
</template>

<script>
export default {
  name: 'NavBarComponent',
}
</script>

<style scoped>
.navbar {
  background: #fafafa !important;
  box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.navbar-title {
  font-size: 1.5rem;
  font-weight: 700;
  letter-spacing: 1px;
  color: #222;
}

.franqueado-btn {
  background: linear-gradient(90deg, #ff6b35 0%, #f7931e 100%) !important;
  color: #fff !important;
  box-shadow: 0 2px 8px rgba(255,107,53,0.08);
  border-radius: 8px;
  text-transform: none;
}

.gap-4 > * + * {
  margin-left: 1.5rem;
}

@media (max-width: 960px) {
  .d-md-flex {
    display: none !important;
  }
  .d-md-none {
    display: block !important;
  }
}
@media (min-width: 961px) {
  .d-md-flex {
    display: flex !important;
  }
  .d-md-none {
    display: none !important;
  }
}
</style>
