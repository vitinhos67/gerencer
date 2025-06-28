
<template>
    <div>
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4 font-weight-bold mb-6">
                    Gerenciamento de Usuários
                </h1>
            </v-col>
        </v-row>

        <v-card elevation="2">
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Buscar usuários"
                    single-line
                    hide-details
                    class="mr-4"
                ></v-text-field>
                <v-btn
                    color="primary"
                    @click="showAddDialog = true"
                >
                    <v-icon left>mdi-account-plus</v-icon>
                    Adicionar Usuário
                </v-btn>
            </v-card-title>

            <v-data-table
                :headers="headers"
                :items="users"
                :search="search"
                :loading="loading"
                class="elevation-1"
            >
                <template #item.actions="{ item }" >
                    <div class="ma-2">
                        <v-icon color="primary" @click="editUser(item)">mdi-pencil</v-icon>
                        <v-icon color="error" @click="deleteUser(item)">mdi-delete</v-icon>
                    </div>
                </template>
            </v-data-table>
        </v-card>

        <v-dialog v-model="showAddDialog" max-width="500px">
            <v-card>
                <v-card-title>
                    {{ editingUser ? 'Editar Usuário' : 'Adicionar Usuário' }}
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-text-field
                            v-model="userForm.name"
                            label="Nome"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="userForm.email"
                            label="Email"
                            type="email"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="userForm.password"
                            label="Senha"
                            type="password"
                            :required="!editingUser"
                        ></v-text-field>
                        <v-select
                            v-model="userForm.role"
                            :items="roles"
                            label="Perfil"
                            required
                        ></v-select>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="grey darken-1"
                        text
                        @click="showAddDialog = false"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="primary"
                        @click="saveUser"
                    >
                        Salvar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

interface User {
    id: number
    name: string
    email: string
    role: string
    status: string
    createdAt: string
}

interface UserForm {
    name: string
    email: string
    password: string
    role: string
}

export default defineComponent({
    name: 'UsersComponent',
    data() {
        return {
            search: '',
            loading: false,
            showAddDialog: false,
            editingUser: null as User | null,
            userForm: {
                name: '',
                email: '',
                password: '',
                role: ''
            } as UserForm,
            roles: ['Admin', 'Usuário', 'Editor'],
            headers: [
                { text: 'Nome', value: 'name' },
                { text: 'Email', value: 'email' },
                { text: 'Perfil', value: 'role' },
                { text: 'Status', value: 'status' },
                { text: 'Data de Criação', value: 'createdAt' },
                { text: 'Ações', value: 'actions', sortable: false }
            ],
            users: [
                {
                    id: 1,
                    name: 'João Silva',
                    email: 'joao@example.com',
                    role: 'Admin',
                    status: 'Ativo',
                    createdAt: '2024-01-15'
                },
                {
                    id: 2,
                    name: 'Maria Santos',
                    email: 'maria@example.com',
                    role: 'Usuário',
                    status: 'Ativo',
                    createdAt: '2024-01-20'
                }
            ] as User[]
        }
    },
    methods: {
        editUser(user: User) {
            this.editingUser = user
            this.userForm = {
                name: user.name,
                email: user.email,
                password: '',
                role: user.role
            }
            this.showAddDialog = true
        },
        deleteUser(user: User) {
            // Implementar lógica de exclusão
            console.log('Deletar usuário:', user)
        },
        saveUser() {
            // Implementar lógica de salvamento
            console.log('Salvar usuário:', this.userForm)
            this.showAddDialog = false
            this.editingUser = null
            this.userForm = {
                name: '',
                email: '',
                password: '',
                role: ''
            }
        }
    }
})
</script> 