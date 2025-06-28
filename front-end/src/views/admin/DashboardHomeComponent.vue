<template>
    <div>
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4 font-weight-bold mb-6">
                    Painel Administrativo
                </h1>
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
        return {}
    },
    methods: {
        navigateTo(path: string) {
            this.$router.push(path)
        }
    }
})
</script>

<style scoped>
</style> 