<template>
    <div>
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4 font-weight-bold mb-6">
                    Relatórios
                </h1>
            </v-col>
        </v-row>

        <!-- Filtros -->
        <v-row class="mb-6">
            <v-col cols="12" md="3">
                <v-select
                    v-model="selectedReport"
                    :items="reportTypes"
                    label="Tipo de Relatório"
                    @change="generateReport"
                ></v-select>
            </v-col>
            <v-col cols="12" md="3">
                <v-menu
                    v-model="startDateMenu"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template #activator="{ props }">
                        <v-text-field
                            v-model="startDate"
                            label="Data Inicial"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="props"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        v-model="startDate"
                        @update:model-value="generateReport"
                    ></v-date-picker>
                </v-menu>
            </v-col>
            <v-col cols="12" md="3">
                <v-menu
                    v-model="endDateMenu"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template #activator="{ props }">
                        <v-text-field
                            v-model="endDate"
                            label="Data Final"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="props"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        v-model="endDate"
                        @update:model-value="generateReport"
                    ></v-date-picker>
                </v-menu>
            </v-col>
            <v-col cols="12" md="3">
                <v-btn
                    color="primary"
                    block
                    @click="exportReport"
                    :loading="exporting"
                >
                    <v-icon left>mdi-download</v-icon>
                    Exportar
                </v-btn>
            </v-col>
        </v-row>

        <!-- Gráficos -->
        <v-row>
            <v-col cols="12" md="6">
                <v-card elevation="2">
                    <v-card-title>
                        Usuários por Mês
                    </v-card-title>
                    <v-card-text>
                        <div style="height: 300px; display: flex; align-items: center; justify-content: center;">
                            <v-icon size="64" color="primary">mdi-chart-line</v-icon>
                        </div>
                        <p class="text-center text-medium-emphasis">
                            Gráfico de usuários registrados por mês
                        </p>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card elevation="2">
                    <v-card-title>
                        Receita por Período
                    </v-card-title>
                    <v-card-text>
                        <div style="height: 300px; display: flex; align-items: center; justify-content: center;">
                            <v-icon size="64" color="success">mdi-chart-bar</v-icon>
                        </div>
                        <p class="text-center text-medium-emphasis">
                            Gráfico de receita por período
                        </p>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <!-- Tabela de dados -->
        <v-row class="mt-6">
            <v-col cols="12">
                <v-card elevation="2">
                    <v-card-title>
                        Dados do Relatório
                    </v-card-title>
                    <v-data-table
                        :headers="tableHeaders"
                        :items="reportData"
                        :loading="loading"
                        class="elevation-1"
                    >
                        <template #item.amount="{ item }">
                            <span class="font-weight-bold" :class="getAmountColor(item.amount)">
                                {{ formatCurrency(item.amount) }}
                            </span>
                        </template>
                        <template #item.status="{ item }">
                            <v-chip
                                :color="getStatusColor(item.status)"
                                size="small"
                            >
                                {{ item.status }}
                            </v-chip>
                        </template>
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>

        <!-- Resumo -->
        <v-row class="mt-6">
            <v-col cols="12" md="3">
                <v-card elevation="2" color="primary" dark>
                    <v-card-text class="text-center">
                        <div class="text-h4 font-weight-bold">
                            {{ summary.total }}
                        </div>
                        <div class="text-subtitle-1">
                            Total de Registros
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="3">
                <v-card elevation="2" color="success" dark>
                    <v-card-text class="text-center">
                        <div class="text-h4 font-weight-bold">
                            {{ formatCurrency(summary.totalAmount) }}
                        </div>
                        <div class="text-subtitle-1">
                            Valor Total
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="3">
                <v-card elevation="2" color="info" dark>
                    <v-card-text class="text-center">
                        <div class="text-h4 font-weight-bold">
                            {{ summary.average }}
                        </div>
                        <div class="text-subtitle-1">
                            Média
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="3">
                <v-card elevation="2" color="warning" dark>
                    <v-card-text class="text-center">
                        <div class="text-h4 font-weight-bold">
                            {{ summary.pending }}
                        </div>
                        <div class="text-subtitle-1">
                            Pendentes
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

interface ReportData {
    id: number
    date: string
    description: string
    amount: number
    status: string
    category: string
}

interface Summary {
    total: number
    totalAmount: number
    average: number
    pending: number
}

export default defineComponent({
    name: 'ReportsComponent',
    data() {
        return {
            selectedReport: 'sales',
            reportTypes: [
                { title: 'Relatório de Vendas', value: 'sales' },
                { title: 'Relatório de Usuários', value: 'users' },
                { title: 'Relatório Financeiro', value: 'financial' },
                { title: 'Relatório de Atividades', value: 'activities' }
            ],
            startDate: new Date().toISOString().substr(0, 10),
            endDate: new Date().toISOString().substr(0, 10),
            startDateMenu: false,
            endDateMenu: false,
            loading: false,
            exporting: false,
            tableHeaders: [
                { text: 'Data', value: 'date' },
                { text: 'Descrição', value: 'description' },
                { text: 'Valor', value: 'amount' },
                { text: 'Status', value: 'status' },
                { text: 'Categoria', value: 'category' }
            ],
            reportData: [
                {
                    id: 1,
                    date: '2024-01-15',
                    description: 'Venda de Produto A',
                    amount: 1500.00,
                    status: 'Concluído',
                    category: 'Vendas'
                },
                {
                    id: 2,
                    date: '2024-01-16',
                    description: 'Assinatura Mensal',
                    amount: 299.90,
                    status: 'Pendente',
                    category: 'Assinaturas'
                },
                {
                    id: 3,
                    date: '2024-01-17',
                    description: 'Serviço de Consultoria',
                    amount: 2500.00,
                    status: 'Concluído',
                    category: 'Serviços'
                }
            ] as ReportData[],
            summary: {
                total: 3,
                totalAmount: 4299.90,
                average: 1433.30,
                pending: 1
            } as Summary
        }
    },
    methods: {
        generateReport() {
            this.loading = true
            // Simular carregamento
            setTimeout(() => {
                this.loading = false
            }, 1000)
        },
        exportReport() {
            this.exporting = true
            // Simular exportação
            setTimeout(() => {
                this.exporting = false
            }, 2000)
        },
        formatCurrency(value: number): string {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value)
        },
        getAmountColor(amount: number): string {
            return amount > 1000 ? 'text-success' : 'text-primary'
        },
        getStatusColor(status: string): string {
            switch (status) {
                case 'Concluído':
                    return 'success'
                case 'Pendente':
                    return 'warning'
                case 'Cancelado':
                    return 'error'
                default:
                    return 'grey'
            }
        }
    },
    mounted() {
        this.generateReport()
    }
})
</script> 