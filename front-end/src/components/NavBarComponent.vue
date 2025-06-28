<template>
  <v-app-bar
    color="#f5f5f7"
    height="80"
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
      <div class="d-none d-md-flex align-center gap-3">
        <v-menu offset-y>
          <template #activator="{ props }">
            <v-btn variant="text" v-bind="props">
              Sobre
              <v-icon right>mdi-chevron-down</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item to="/about">
              <v-list-item-title>Quem somos</v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Nossa missão</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-menu offset-y>
          <template #activator="{ props }">
            <v-btn variant="text" v-bind="props">
              Contato
              <v-icon right>mdi-chevron-down</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item>
              <v-list-item-title>Email</v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Telefone</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>

      <!-- Botões de ação (desktop) -->
      <div class="d-none d-md-flex align-center gap-2 navbar-actions">
        <v-btn
          class="franqueado-btn"
          color="orange"
          variant="flat"
        >
          Seja um franqueado
        </v-btn>
        <v-btn color="primary" variant="outlined">Login</v-btn>
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
            <v-btn block color="orange" class="franqueado-btn" variant="flat">Seja um franqueado</v-btn>
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
  background: #f5f5f7 !important;
  box-shadow: 0 1px 4px rgba(0,0,0,0.02);
  min-height: 80px;
}

.navbar-title {
  font-size: 1.6rem;
  font-weight: 700;
  letter-spacing: 1px;
  color: #222;
}

.gap-3 > * + * {
  margin-left: 1.2rem;
}
.gap-2 > * + * {
  margin-left: 0.7rem;
}

.navbar-actions {
  margin-left: 2rem;
}

.franqueado-btn {
  background: #ff6b35 !important;
  color: #fff !important;
  border-radius: 8px;
  font-weight: 600;
  text-transform: none;
  letter-spacing: 0.5px;
  box-shadow: none !important;
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
