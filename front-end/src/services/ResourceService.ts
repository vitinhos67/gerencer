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
    private resource: string;
    protected http: AxiosInstance;

    constructor(resource: string) {
        this.resource = resource;
        this.http = axios.create({
            baseURL: (process.env as any).VUE_APP_API_URL || 'http://localhost:8000/api',
            headers: {
                'Content-Type': 'application/json'
            }
        });
    }

    async get(id: string | number): Promise<ApiResponse<T>> {
        const response: AxiosResponse<ApiResponse<T>> = await this.http.get(`/${this.resource}/${id}`);
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
