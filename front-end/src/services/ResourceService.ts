import axios, { type AxiosInstance, type AxiosResponse } from 'axios';

export interface ApiResponse<T> {
    data: any;
    message?: string;
    success: boolean;
}

export interface PaginatedResponse<T> {
    data: T[];
    message?: string;
    success: boolean;
    total?: number;
    page?: number;
    limit?: number;
}

class ResourceService<T> {
    protected resource: string;
    protected http: AxiosInstance;

    constructor(resource: string) {
        this.resource = resource;
        this.http = axios.create({
            baseURL: (process.env as any).VUE_APP_API_URL || 'http://localhost:8000/api',
            headers: {
                'Content-Type': 'application/json'
            },
            withCredentials: true // Habilitar cookies por padrão
        });

        this.setupInterceptors();
    }

    private setupInterceptors(): void {
        // Interceptor para adicionar token Bearer quando necessário
        this.http.interceptors.request.use(
            (config) => {
                const authMethod = localStorage.getItem('auth_method');
                const token = localStorage.getItem('token');

                // Se estiver usando tokens, adicionar o header Authorization
                if (authMethod === 'token' && token) {
                    config.headers.Authorization = `Bearer ${token}`;
                }

                // Para cookies, garantir que withCredentials está habilitado
                if (authMethod === 'cookies') {
                    config.withCredentials = true;
                }

                return config;
            },
            (error) => {
                return Promise.reject(error);
            }
        );

        // Interceptor para tratar erros de autenticação
        this.http.interceptors.response.use(
            (response) => {
                return response;
            },
            (error) => {
                if (error.response?.status === 401) {
                    // Token expirado ou inválido
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    localStorage.removeItem('auth_method');

                    // Redirecionar para login se não estiver na página de login
                    if (window.location.pathname !== '/login') {
                        window.location.href = '/login';
                    }
                }
                return Promise.reject(error);
            }
        );
    }

    async get(id: string | number): Promise<ApiResponse<T>> {
        const response: AxiosResponse<ApiResponse<T>> = await this.http.get(`/${this.resource}/${id}`);
        return response.data;
    }

    async getWithParam(param: string): Promise<ApiResponse<T>> {
        const response: AxiosResponse<ApiResponse<T>> = await this.http.get(`/${this.resource}/${param}`);
        return response.data;
    }

    async getAll(params?: Record<string, any>): Promise<PaginatedResponse<T>> {
        const response: AxiosResponse<PaginatedResponse<T>> = await this.http.get(`/${this.resource}`, { params });
        return response.data;
    }

    async create(data: Partial<T>): Promise<ApiResponse<T>> {
        const response: AxiosResponse<ApiResponse<T>> = await this.http.post(`/${this.resource}`, data);
        return response.data;
    }

    async update(id: string | number, data: Partial<T>): Promise<ApiResponse<T>> {
        const response: AxiosResponse<ApiResponse<T>> = await this.http.put(`/${this.resource}/${id}`, data);
        return response.data;
    }

    async delete(id: string | number): Promise<ApiResponse<boolean>> {
        const response: AxiosResponse<ApiResponse<boolean>> = await this.http.delete(`/${this.resource}/${id}`);
        return response.data;
    }
}

export default ResourceService;
