import ResourceService from './ResourceService'
import type { Supplier, SupplierResponse, SupplierListResponse } from '../types/supplier'

class SupplierService extends ResourceService<Supplier> {
    constructor() {
        super('suppliers');
    }

    // Métodos específicos para Supplier
    async getSupplier(id: number): Promise<SupplierResponse> {
        return this.get(id);
    }

    async getAllSuppliers(params?: Record<string, any>): Promise<SupplierListResponse> {
        return this.getAll(params);
    }

    async createSupplier(supplier: Partial<Supplier>): Promise<SupplierResponse> {
        return this.create(supplier);
    }

    async updateSupplier(id: number, supplier: Partial<Supplier>): Promise<SupplierResponse> {
        return this.update(id, supplier);
    }

    async deleteSupplier(id: number): Promise<{ data: boolean; message?: string; success: boolean }> {
        return this.delete(id);
    }

    // Métodos específicos para Supplier
    async getSuppliersByStatus(active: boolean): Promise<SupplierListResponse> {
        return this.getAll({ active });
    }

    async searchSuppliers(query: string): Promise<SupplierListResponse> {
        return this.getAll({ search: query });
    }
}

export default SupplierService;
