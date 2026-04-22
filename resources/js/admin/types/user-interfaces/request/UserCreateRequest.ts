export interface UserCreateRequest {
    id: number;
    email: string;
    name: string;
    manager_id?: number;
    department_id?: number;
    role: number;
}
