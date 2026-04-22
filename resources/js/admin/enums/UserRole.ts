import { useI18n } from "vue-i18n"
import { common } from "../composable/common"
import { Option } from "../types/common/Option"
import { computed } from "vue"

export type UserRole = typeof USER_ROLE[keyof typeof USER_ROLE]

export const USER_ROLE = {
    ADMIN: 1,
    MANAGER: 2,
    EMPLOYEE: 3,
} as const

export const UserRoleKeyMap: Record<UserRole, string> = {
    [USER_ROLE.ADMIN]: 'ADMIN',
    [USER_ROLE.MANAGER]: 'MANAGER',
    [USER_ROLE.EMPLOYEE]: 'EMPLOYEE',
}

export const USER_ROLE_COLOR: Record<UserRole, string> = {
    [USER_ROLE.ADMIN]: '',
    [USER_ROLE.MANAGER]: '',
    [USER_ROLE.EMPLOYEE]: '',
}

export function userRoleOptions() {
    return computed<Option[]>(() =>
        Object.values(USER_ROLE).map(role => ({
            value: String(role),
            label: common().resolveMessage(`trans2.UserRoleEnum.${UserRoleKeyMap[role]}`),
        }))
    )
}

export function getText(
    role: UserRole,
): string {
    return common().resolveMessage(`trans2.UserRoleEnum.${UserRoleKeyMap[role]}`)
}

export function getColor(role: UserRole): string {
    return USER_ROLE_COLOR[role]
}
