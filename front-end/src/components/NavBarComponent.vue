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
        <span class="navbar-title ml-2" @click="goHome">Gerencer</span>
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
        <!-- Usuário NÃO logado -->
        <template v-if="!isAuthenticated">
          <v-btn
            class="franqueado-btn"
            color="orange"
            variant="flat"
          >
            Seja um franqueado
          </v-btn>
          <v-btn to="/login" color="primary" variant="outlined">Login</v-btn>
        </template>

        <!-- Usuário logado -->
        <template v-else>
          <!-- Menu do usuário -->
          <v-menu offset-y>
            <template #activator="{ props }">
              <v-btn variant="text" v-bind="props" class="user-menu-btn">
                <v-avatar size="32" class="mr-2">
                  <v-icon>mdi-account</v-icon>
                </v-avatar>
                <span class="user-name">{{ user?.name }}</span>
                <v-icon right>mdi-chevron-down</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item to="/admin/dashboard">
                <template #prepend>
                  <v-icon>mdi-view-dashboard</v-icon>
                </template>
                <v-list-item-title>Painel Administrativo</v-list-item-title>
              </v-list-item>
              <v-list-item to="/admin/settings">
                <template #prepend>
                  <v-icon>mdi-cog</v-icon>
                </template>
                <v-list-item-title>Configurações</v-list-item-title>
              </v-list-item>
              <v-divider></v-divider>
              <v-list-item @click="handleLogout">
                <template #prepend>
                  <v-icon>mdi-logout</v-icon>
                </template>
                <v-list-item-title>Sair</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>
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
          
          <!-- Opções específicas para usuário logado (mobile) -->
          <template v-if="isAuthenticated">
            <v-divider></v-divider>
            <v-list-item to="/admin/dashboard">
              <template #prepend>
                <v-icon>mdi-view-dashboard</v-icon>
              </template>
              <v-list-item-title>Painel Administrativo</v-list-item-title>
            </v-list-item>
            <v-list-item to="/admin/settings">
              <template #prepend>
                <v-icon>mdi-cog</v-icon>
              </template>
              <v-list-item-title>Configurações</v-list-item-title>
            </v-list-item>
            <v-list-item @click="handleLogout">
              <template #prepend>
                <v-icon>mdi-logout</v-icon>
              </template>
              <v-list-item-title>Sair</v-list-item-title>
            </v-list-item>
          </template>
          
          <!-- Opções para usuário não logado (mobile) -->
          <template v-else>
            <v-divider></v-divider>
            <v-list-item to="/login">
              <template #prepend>
                <v-icon>mdi-login</v-icon>
              </template>
              <v-list-item-title>Login</v-list-item-title>
            </v-list-item>
          </template>
        </v-list>
      </v-menu>
    </v-container>
  </v-app-bar>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useAuth } from '@/composables/useAuth'

export default defineComponent({
  name: 'NavBarComponent',
  setup() {
    const { user, isAuthenticated, logout } = useAuth()

    const goHome = () => {
      window.location.href = '/'
    }

    const handleLogout = async () => {
      try {
        await logout()
        // Redirecionar para home após logout
        window.location.href = '/'
      } catch (error) {
        console.error('Erro no logout:', error)
        // Mesmo com erro, redirecionar
        window.location.href = '/'
      }
    }

    return {
      user,
      isAuthenticated,
      goHome,
      handleLogout
    }
  }
})
</script>

<style scoped>
.navbar {
  background: #ffffff !important;
  box-shadow: 0 1px 4px rgba(0,0,0,0.02);
  min-height: 80px;
}

.navbar-title {
  font-size: 1.6rem;
  font-weight: 700;
  letter-spacing: 1px;
  color: #222;
  cursor: pointer;
  transition: color 0.3s ease;
}

.navbar-title:hover {
  color: #ff6b35;
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

.user-menu-btn {
  display: flex;
  align-items: center;
  padding: 8px 16px;
  border-radius: 8px;
  transition: background-color 0.3s ease;
}

.user-menu-btn:hover {
  background-color: rgba(0, 0, 0, 0.05);
}

.user-name {
  font-weight: 500;
  margin: 0 8px;
  max-width: 120px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
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
