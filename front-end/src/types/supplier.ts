export interface Supplier {
  id?: number
  name: string
  email: string
  phone?: string
  address?: string
  city?: string
  state?: string
  zipCode?: string
  cnpj?: string
  description?: string
  active?: boolean
  createdAt?: string
  updatedAt?: string
}

export interface SupplierResponse {
  data: Supplier
  message?: string
  success: boolean
}

export interface SupplierListResponse {
  data: Supplier[]
  message?: string
  success: boolean
  total?: number
  page?: number
  limit?: number
} 