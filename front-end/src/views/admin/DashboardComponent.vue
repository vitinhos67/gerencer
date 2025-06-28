<template>
    <v-app>
        <!-- Barra lateral -->
        <v-navigation-drawer
            v-model="drawer"
            app
            dark
            color="primary"
            width="280"
        >
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h6">
                        Painel Administrativo
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        Gerenciador
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list
                dense
                nav
            >
                <v-list-item
                    v-for="item in menuItems"
                    :key="item.title"
                    :to="item.to"
                    link
                    class="mb-2"
                >
                    <template #prepend>
                        <v-icon>{{ item.icon }}</v-icon>
                    </template>

                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>

            <template #append>
                <div class="pa-2">
                    <v-btn
                        block
                        color="error"
                        @click="handleLogout"
                        :loading="loading"
                    >
                        <v-icon left>mdi-logout</v-icon>
                        Sair
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <v-app-bar
            app
            color="white"
            elevation="1"
        >
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            
            <v-toolbar-title class="text-h6 font-weight-bold">
                {{ currentPageTitle }}
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon>
                <v-icon>mdi-bell</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <v-container fluid class="pa-6">
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useAuth } from '@/composables/useAuth'

interface MenuItem {
    title: string
    icon: string
    to: string
}

export default defineComponent({
    name: 'DashboardComponent',
    setup() {
        const { user, userRole, logout, loading } = useAuth()

        return {
            user,
            userRole,
            logout,
            loading
        }
    },
    data() {
        return {
            drawer: true,
            menuItems: [
                {
                    title: 'Dashboard',
                    icon: 'mdi-view-dashboard',
                    to: '/admin/dashboard'
                },
                {
                    title: 'Usuários',
                    icon: 'mdi-account-group',
                    to: '/admin/users'
                },
                {
                    title: 'Configurações',
                    icon: 'mdi-cog',
                    to: '/admin/settings'
                },
                {
                    title: 'Relatórios',
                    icon: 'mdi-chart-bar',
                    to: '/admin/reports'
                }
            ] as MenuItem[]
        }
    },
    computed: {
        currentPageTitle(): string {
            const currentItem = this.menuItems.find(item => item.to === this.$route.path)
            return currentItem ? currentItem.title : 'Dashboard'
        }
    },
    methods: {
        async handleLogout() {
            try {
                await this.logout()
                this.$router.push('/login')
            } catch (error) {
                console.error('Erro no logout:', error)
                this.$router.push('/login')
            }
        }
    }
})
</script>

<style scoped>
.v-navigation-drawer {
    border-right: 1px solid rgba(255, 255, 255, 0.12);
}

.v-list-item {
    border-radius: 8px;
    margin: 0 8px;
}

.v-list-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.v-list-item--active {
    background-color: rgba(255, 255, 255, 0.2) !important;
}
</style> 