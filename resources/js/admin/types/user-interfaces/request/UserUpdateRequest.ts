export interface UserUpdateRequest {
    id: number;
    email: string;
    name: string;
    manager_id?: number;
    department_id?: number;
    role: string;
    description: string;
    rolesCheckbox: string[];
}
