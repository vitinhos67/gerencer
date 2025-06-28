<template>
    <NavBarComponent></NavBarComponent>
    <v-container class="d-flex justify-center align-center" style="min-height: 100vh;">
        <v-card elevation="2" class="pa-6" max-width="400" width="100%">
            <v-card-title class="justify-center">
                Login
            </v-card-title>
            <v-card-text>
                <v-form @submit.prevent="handleLogin">
                    <v-text-field v-model="form.email" label="Email" type="email" class="mb-6"
                        :error-messages="errors.email" @input="clearError('email')" />
                    <v-text-field v-model="form.password" label="Senha" type="password"
                        :error-messages="errors.password" @input="clearError('password')" />
                    <v-btn type="submit" color="primary" block large class="mt-4" :loading="loading"
                        :disabled="loading">
                        {{ loading ? 'Entrando...' : 'Entrar' }}
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
    <FooterComponent></FooterComponent>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import NavBarComponent from '@/components/NavBarComponent.vue'
import LoginService from '@/services/LoginService'
import FooterComponent from '@/components/FooterComponent.vue'

interface LoginForm {
    email: string
    password: string
}

interface FormErrors {
    email: string
    password: string
}

export default defineComponent({
    name: 'LoginComponent',
    components: {
        NavBarComponent,
        FooterComponent
    },
    data() {
        return {
            form: {
                email: '',
                password: ''
            } as LoginForm,
            errors: {
                email: '',
                password: ''
            } as FormErrors,
            loading: false
        }
    },
    methods: {
        async handleLogin() {
            if (!this.validateForm()) {
                return
            }

            this.loading = true
            this.clearErrors()

            try {
                const service = new LoginService()
                const response = await service.login(this.form)
                if (response.success) {
                    this.$router.push('/admin/dashboard')
                } else {
                    console.error('Erro no login')
                }
            } catch (error: any) {
                console.log(error);
                // Mostrar erro genérico para o usuário
                this.errors.email = 'Credenciais inválidas'
                this.errors.password = 'Credenciais inválidas'
            } finally {
                this.loading = false
            }
        },

        validateForm(): boolean {
            let isValid = true

            if (!this.form.email) {
                this.errors.email = 'Email é obrigatório'
                isValid = false
            } else if (!this.isValidEmail(this.form.email)) {
                this.errors.email = 'Email inválido'
                isValid = false
            }

            if (!this.form.password) {
                this.errors.password = 'Senha é obrigatória'
                isValid = false
            }

            return isValid
        },

        isValidEmail(email: string): boolean {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
            return emailRegex.test(email)
        },

        clearErrors() {
            this.errors = {
                email: '',
                password: ''
            }
        },

        clearError(field: keyof FormErrors) {
            this.errors[field] = ''
        }
    }
})
</script>

<style scoped></style>
