<template>
    <GenericCrud
        title=""
        search-label="Buscar usuários"
        add-button-text="Adicionar Usuário"
        add-dialog-title="Adicionar Usuário"
        edit-dialog-title="Editar Usuário"
        :headers="headers"
        :items="users"
        :loading="loading"
        :form="userForm"
        :custom-templates="customTemplates"
        @edit="editUser"
        @delete="deleteUser"
        @save="saveUser"
        @close-dialog="resetForm"
    >
        <template #form="{ form, editing }">
            <v-form ref="form">
                <v-text-field
                    v-model="form.name"
                    label="Nome"
                    required
                ></v-text-field>
                <v-text-field
                    v-model="form.email"
                    label="Email"
                    type="email"
                    required
                ></v-text-field>
                <v-text-field
                    v-model="form.password"
                    label="Senha"
                    type="password"
                    :required="!editing"
                ></v-text-field>
                <v-select
                    v-model="form.role"
                    :items="roles"
                    label="Perfil"
                    required
                ></v-select>
            </v-form>
        </template>
    </GenericCrud>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import type { User, UserForm } from '@/types/user'
import GenericCrud from '@/components/GenericCrud.vue'
// eslint-disable-next-line vue/no-unused-components
import RolesTemplate from '@/components/templates/RolesTemplate.vue'
// eslint-disable-next-line vue/no-unused-components
import DateTemplate from '@/components/templates/DateTemplate.vue'
const UserService = new (await import('@/services/UserService')).default()

export default defineComponent({
    name: 'UsersComponent',
    components: {
        GenericCrud
    },
    data() {
        return {
            loading: false,
            userForm: {
                name: '',
                email: '',
                password: '',
                role: ''
            } as UserForm,
            roles: ['admin', 'usuário', 'editor'],
            headers: [
                { text: 'Nome', value: 'name' },
                { text: 'Email', value: 'email' },
                { text: 'Perfis', value: 'roles', sortable: false },
                { text: 'Data de Criação', value: 'created_at' },
                { text: 'Ações', value: 'actions', sortable: false }
            ],
            users: [] as User[]
        }
    },
    computed: {
        customTemplates() {
            return {
                'item.roles': RolesTemplate,
                'item.created_at': DateTemplate
            }
        }
    },
    methods: {
        editUser(user: User) {
            this.userForm = {
                name: user.name,
                email: user.email,
                password: '',
                role: user.roles.length > 0 ? user.roles[0].name : ''
            }
        },
        deleteUser(user: User) {
            // Implementar lógica de exclusão
            console.log('Deletar usuário:', user)
        },
        saveUser(form: UserForm) {
            // Implementar lógica de salvamento
            console.log('Salvar usuário:', form)
        },
        resetForm() {
            this.userForm = {
                name: '',
                email: '',
                password: '',
                role: ''
            }
        }
    },
    async mounted() {
        this.loading = true
       
        try {
            const users = await UserService.getWithParam('all');
            this.users = users.data;
            this.loading = false;
        } catch (error) {
            console.error('Erro ao carregar usuários:', error);
            this.loading = false;
        }
    }
})
</script> 