<template>
    <div>
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4 font-weight-bold mb-6">
                    Bem-vindo ao Painel Administrativo
                </h1>
            </v-col>
        </v-row>

        <!-- Cards de estatísticas -->
        <v-row>
            <v-col cols="12" sm="6" md="3">
                <v-card class="mx-auto" elevation="2">
                    <v-card-text class="text-center">
                        <v-icon size="48" color="primary" class="mb-4">
                            mdi-account-group
                        </v-icon>
                        <div class="text-h4 font-weight-bold text-primary">
                            {{ stats.users }}
                        </div>
                        <div class="text-subtitle-1 text-medium-emphasis">
                            Usuários Ativos
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" md="3">
                <v-card class="mx-auto" elevation="2">
                    <v-card-text class="text-center">
                        <v-icon size="48" color="success" class="mb-4">
                            mdi-chart-line
                        </v-icon>
                        <div class="text-h4 font-weight-bold text-success">
                            {{ stats.revenue }}
                        </div>
                        <div class="text-subtitle-1 text-medium-emphasis">
                            Receita Mensal
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" md="3">
                <v-card class="mx-auto" elevation="2">
                    <v-card-text class="text-center">
                        <v-icon size="48" color="warning" class="mb-4">
                            mdi-file-document
                        </v-icon>
                        <div class="text-h4 font-weight-bold text-warning">
                            {{ stats.orders }}
                        </div>
                        <div class="text-subtitle-1 text-medium-emphasis">
                            Pedidos Hoje
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" md="3">
                <v-card class="mx-auto" elevation="2">
                    <v-card-text class="text-center">
                        <v-icon size="48" color="info" class="mb-4">
                            mdi-eye
                        </v-icon>
                        <div class="text-h4 font-weight-bold text-info">
                            {{ stats.views }}
                        </div>
                        <div class="text-subtitle-1 text-medium-emphasis">
                            Visualizações
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <!-- Gráficos e tabelas -->
        <v-row class="mt-6">
            <v-col cols="12" md="8">
                <v-card elevation="2">
                    <v-card-title>
                        Atividade Recente
                    </v-card-title>
                    <v-card-text>
                        <v-list>
                            <v-list-item
                                v-for="activity in recentActivities"
                                :key="activity.id"
                                class="mb-2"
                            >
                                <v-list-item-avatar>
                                    <v-icon :color="activity.color">
                                        {{ activity.icon }}
                                    </v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ activity.title }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{ activity.description }}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-chip
                                        :color="activity.status === 'success' ? 'success' : 'warning'"
                                        size="small"
                                    >
                                        {{ activity.status }}
                                    </v-chip>
                                </v-list-item-action>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="4">
                <v-card elevation="2">
                    <v-card-title>
                        Ações Rápidas
                    </v-card-title>
                    <v-card-text>
                        <v-btn
                            block
                            color="primary"
                            class="mb-3"
                            @click="navigateTo('/admin/users')"
                        >
                            <v-icon left>mdi-account-plus</v-icon>
                            Adicionar Usuário
                        </v-btn>
                        <v-btn
                            block
                            color="success"
                            class="mb-3"
                            @click="navigateTo('/admin/reports')"
                        >
                            <v-icon left>mdi-file-chart</v-icon>
                            Gerar Relatório
                        </v-btn>
                        <v-btn
                            block
                            color="info"
                            @click="navigateTo('/admin/settings')"
                        >
                            <v-icon left>mdi-cog</v-icon>
                            Configurações
                        </v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

interface Activity {
    id: number
    title: string
    description: string
    icon: string
    color: string
    status: string
}

interface Stats {
    users: number
    revenue: string
    orders: number
    views: number
}

export default defineComponent({
    name: 'DashboardHomeComponent',
    data() {
        return {
            stats: {
                users: 1250,
                revenue: 'R$ 45.230',
                orders: 89,
                views: 12500
            } as Stats,
            recentActivities: [] as Activity[]
        }
    },
    methods: {
        navigateTo(path: string) {
            this.$router.push(path)
        }
    }
})
</script>

<style scoped>
.v-card {
    transition: transform 0.2s ease-in-out;
}

.v-card:hover {
    transform: translateY(-2px);
}
</style> 