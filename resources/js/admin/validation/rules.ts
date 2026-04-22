import { reactive } from 'vue';
import { common } from '../composable/common';
import { Rule } from './../types/validation/Rule';
import { RuleName } from "./type"

export const required: Rule = {
    name: RuleName.REQUIRED,
    message: (attribute) => common().resolveMessage('validation.required',{ attribute }),
    validate(value) {
        if (value === null || value === undefined) return false

        // string
        if (typeof value === 'string') {
            return value.trim() !== ''
        }

        // array (checkbox multiple, multi-select)
        if (Array.isArray(value)) {
            return value.length > 0
        }

        // object
        if (typeof value === 'object') {
            return Object.keys(value).length > 0
        }

        // number / boolean
        return true
    },
}

export const email: Rule = {
    name: RuleName.EMAIL,
    message: (attribute) => common().resolveMessage('validation.email',{ attribute }),
    validate(value) {
        if (!value) return true
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
    },
}

export const inEnum = (enumObject: Record<string, string | number>): Rule => ({
    name: RuleName.IN,
    message: (attribute) => common().resolveMessage('validation.in',{ attribute }),
    validate(value) {
        if (value === null || value === undefined || value === "") return true

        const enumValues = Object.values(enumObject).map(String)
        return enumValues.includes(String(value))
    },
})

export const inEnumArray = (
    enumObject: Record<string, string | number>
): Rule => ({
    name: RuleName.IN_ARRAY,
    message: (attribute) => common().resolveMessage('validation.in',{ attribute }),
    validate(value) {
        if (value === null || value === undefined) return true;

        if (!Array.isArray(value)) return false;

        const enumValues = Object.values(enumObject).map(String);

        return value.every((v) => enumValues.includes(String(v)));
    },
})
