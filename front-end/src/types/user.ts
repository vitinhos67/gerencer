export interface Role {
  id: number
  name: string
  guard_name: string
  pivot: {
    model_type: string
    model_id: number
    role_id: number
  }
}

export interface User {
  id?: number
  name: string
  email: string
  email_verified_at?: string | null
  created_at?: string
  updated_at?: string
  roles: Role[]
}

export interface UserForm {
    name: string
    email: string
    password: string
    role: string
}

