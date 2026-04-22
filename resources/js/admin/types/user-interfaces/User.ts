export interface User {
    id: number;
    email: string;
    name: string;
    manager_id?: number;
    department_id?: number;
    role: number;
    del_flag?: number;
    ins_date?: Date | string;
    ins_id?: number;
    upd_date?: Date | string;
    upd_id?: number;
}
