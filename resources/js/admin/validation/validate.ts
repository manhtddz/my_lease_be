import { Rule } from './../types/validation/Rule';

export type RulesMap = Record<string, Rule[]>
export type LabelMap = Record<string, string>

export function validateForm(
    form: any,
    rules: RulesMap,
    labels: LabelMap = {}
) {
    const errors: Record<string, string[]> = {}

    for (const field in rules) {
        const label = labels[field] ?? field

        for (const rule of rules[field]) {
            if (!rule.validate(form[field], form)) {
                if (!errors[field]) errors[field] = []
                errors[field].push(rule.message(label))
            }
        }
    }

    return {
        valid: Object.keys(errors).length === 0,
        errors,
    }
}
