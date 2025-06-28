import ResourceService from './ResourceService'

interface Login {
    email: string;
    password: string;
    use_cookies?: boolean;
}

interface LoginResponse {
    success: boolean;
    data: {
        token?: string;
        user: any;
        supplier?: any;
        message?: string;
    };
}

class LoginService extends ResourceService<Login> {
    constructor() {
        super('auth/login');
    }

    async login(credentials: Login): Promise<LoginResponse> {
        try {
            const response = await this.http.post(`/${this.resource}`, {
                ...credentials,
                use_cookies: true
            }, {
                withCredentials: true,
                headers: {
                    'X-Use-Cookies': 'true'
                }
            });

            const data = response.data;
            
            if (data.success) {
                if (data.data.token) {
                    localStorage.setItem('token', data.data.token);
                }
                localStorage.setItem('user', JSON.stringify(data.data.user));
                localStorage.setItem('auth_method', 'cookies');
            }
            
            return data;
        } catch (error: any) {
            console.warn('Login com cookies falhou, tentando com token:', error.message);
            return {
                success: false,
                data: {
                    token: undefined,
                    user: undefined,
                    supplier: undefined,
                    message: undefined
                }
            }
        }
    }

    async logout(): Promise<void> {
        const authMethod = localStorage.getItem('auth_method');
        
        try {
            if (authMethod === 'cookies') {
                await this.http.post('/auth/logout', {}, {
                    withCredentials: true
                });
            } else {
                await this.http.post('/auth/logout');
            }
        } catch (error) {
            console.error('Erro no logout:', error);
        } finally {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            localStorage.removeItem('auth_method');
        }
    }

    async getCurrentUser(): Promise<any> {
        try {
            const authMethod = localStorage.getItem('auth_method');
            
            if (authMethod === 'cookies') {
                const response = await this.http.get('/auth/me', {
                    withCredentials: true
                });
                return response.data;
            } else {
                const response = await this.http.get('/auth/me');
                return response.data;
            }
        } catch (error) {
            console.error('Erro ao obter usuário atual:', error);
            throw error;
        }
    }

    isAuthenticated(): boolean {
        const token = localStorage.getItem('token');
        const authMethod = localStorage.getItem('auth_method');
        const user = localStorage.getItem('user');
        
        return !!(token || (authMethod === 'cookies' && user));
    }

    getCurrentUserFromStorage(): any {
        const userStr = localStorage.getItem('user');
        if (userStr) {
            try {
                return JSON.parse(userStr);
            } catch (error) {
                console.error('Erro ao parsear usuário do localStorage:', error);
                return null;
            }
        }
        return null;
    }

    getAuthMethod(): string | null {
        return localStorage.getItem('auth_method');
    }

    hasRole(role: string): boolean {
        const user = this.getCurrentUserFromStorage();
        if (user && user.roles) {
            return user.roles.some((userRole: any) => userRole.name === role);
        }
        return false;
    }

    hasPermission(permission: string): boolean {
        const user = this.getCurrentUserFromStorage();
        if (user && user.permissions) {
            return user.permissions.some((userPermission: any) => userPermission.name === permission);
        }
        return false;
    }
}

export default LoginService;
