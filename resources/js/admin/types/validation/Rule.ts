import { RuleName } from "@/admin/validation/type"

export interface Rule {
    name: RuleName
    message: (attribute: string) => string
    validate: (value: any, form?: any) => boolean
}
