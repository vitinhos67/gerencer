import ResourceService from './ResourceService'
import type { Supplier } from '../types/supplier'

class SupplierService extends ResourceService<Supplier> {
    constructor() {
        super('supplier');
    }
}

export default SupplierService;
