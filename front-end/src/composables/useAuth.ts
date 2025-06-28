import { ref, computed } from 'vue'
import LoginService from '@/services/LoginService'

interface User {
    id: number
    name: string
    email: string
    roles?: any[]
    permissions?: any[]
}

export function useAuth() {
    const user = ref<User | null>(null)
    const isAuthenticated = ref(false)
    const authMethod = ref<string | null>(null)
    const loading = ref(false)

    const loginService = new LoginService()

    // Computed properties
    const isAdmin = computed(() => {
        return user.value && user.value.roles?.some((role: any) => role.name === 'admin')
    })

    const isModerator = computed(() => {
        return user.value && user.value.roles?.some((role: any) => role.name === 'moderador')
    })

    const userRole = computed(() => {
        if (!user.value?.roles) return null
        return user.value.roles[0]?.name || null
    })

    // Métodos
    const checkAuth = async () => {
        loading.value = true
        try {
            // Primeiro verificar se há dados no localStorage
            if (loginService.isAuthenticated()) {
                const storedUser = loginService.getCurrentUserFromStorage()
                if (storedUser) {
                    user.value = storedUser
                    isAuthenticated.value = true
                    authMethod.value = loginService.getAuthMethod()
                    return true
                }
            }

            // Se não há dados locais, tentar buscar do servidor
            const response = await loginService.getCurrentUser()
            if (response.success) {
                user.value = response.data.user
                isAuthenticated.value = true
                authMethod.value = loginService.getAuthMethod()
                // Atualizar localStorage
                localStorage.setItem('user', JSON.stringify(response.data.user))
                return true
            }
        } catch (error) {
            console.error('Erro ao verificar autenticação:', error)
            // Se falhar, limpar dados
            logout()
        } finally {
            loading.value = false
        }
        return false
    }

    const login = async (credentials: { email: string; password: string }) => {
        loading.value = true
        try {
            const response = await loginService.login(credentials)
            if (response.success) {
                user.value = response.data.user
                isAuthenticated.value = true
                authMethod.value = loginService.getAuthMethod()
                return { success: true, data: response.data }
            }
            return { success: false, message: 'Credenciais inválidas' }
        } catch (error: any) {
            console.error('Erro no login:', error)
            return { 
                success: false, 
                message: error?.response?.data?.message || 'Erro ao fazer login' 
            }
        } finally {
            loading.value = false
        }
    }

    const logout = async () => {
        loading.value = true
        try {
            await loginService.logout()
        } catch (error) {
            console.error('Erro no logout:', error)
        } finally {
            // Limpar estado local
            user.value = null
            isAuthenticated.value = false
            authMethod.value = null
            loading.value = false
        }
    }

    const hasRole = (role: string): boolean => {
        return loginService.hasRole(role)
    }

    const hasPermission = (permission: string): boolean => {
        return loginService.hasPermission(permission)
    }

    // Inicializar estado ao carregar o composable
    const init = () => {
        if (loginService.isAuthenticated()) {
            const storedUser = loginService.getCurrentUserFromStorage()
            if (storedUser) {
                user.value = storedUser
                isAuthenticated.value = true
                authMethod.value = loginService.getAuthMethod()
            }
        }
    }

    // Inicializar imediatamente
    init()

    return {
        // Estado
        user: computed(() => user.value),
        isAuthenticated: computed(() => isAuthenticated.value),
        authMethod: computed(() => authMethod.value),
        loading: computed(() => loading.value),

        // Computed
        isAdmin,
        isModerator,
        userRole,

        // Métodos
        login,
        logout,
        checkAuth,
        hasRole,
        hasPermission,
        init
    }
} 