import { ComputedRef, ref } from "vue"
import { LabelMap, RulesMap, validateForm } from "../validation/validate"

export function useValidator<T extends object>(
    initialData: T,
    rules: RulesMap,
    labels: LabelMap
) {
    const errors = ref<Record<string, string[]>>({})

    function validate() {
        const result = validateForm(initialData, rules, labels)
        errors.value = result.errors
        return result.valid
    }

    function setErrorsFromBackend(apiErrors: Record<string, string[]>) {
        errors.value = apiErrors
    }

    function clearErrors(field?: string) {
        if (field) delete errors.value[field]
        else errors.value = {}
    }

    return {
        errors,
        validate,
        setErrorsFromBackend,
        clearErrors,
    }
}
