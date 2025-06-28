<template>
    <NavBarComponent></NavBarComponent>
    <v-container class="d-flex justify-center align-center" style="min-height: 80vh;">
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
                    <a class="mt-4" style="display: table; margin: 0 auto; cursor: pointer; text-decoration: underline;"
                        v-on:click="goToForgotPassword">
                        Esqueceu sua senha?
                    </a>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
    <FooterComponent></FooterComponent>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import NavBarComponent from '@/components/NavBarComponent.vue'
import { useAuth } from '@/composables/useAuth'
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
        NavBarComponent
    },
    setup() {
        const { login, loading } = useAuth()

        return {
            login,
            loading
        }
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
            } as FormErrors
        }
    },
    methods: {
        async handleLogin() {
            if (!this.validateForm()) {
                return
            }

            this.clearErrors()

            try {
                const result = await this.login(this.form)

                if (result.success) {
                    this.$router.push('/admin/dashboard')
                } else {
                    this.errors.email = result.message || 'Credenciais inválidas'
                    this.errors.password = result.message || 'Credenciais inválidas'
                }
            } catch (error: any) {
                this.errors.email = 'Erro ao fazer login'
                this.errors.password = 'Erro ao fazer login'
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
        },
        goToForgotPassword() {
            this.$router.push('/forgot-password')
        }
    }
})
</script>

<style scoped></style>
