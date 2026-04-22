<template>
    <div
        :class="rootClass"
        role="group"
        :aria-invalid="hasError"
        :aria-describedby="hasError ? `${id}-error` : undefined"
    >
        <label
            v-for="option in options"
            :key="option.value"
            :for="`${id}_${option.value}`"
            :class="labelClass"
        >
            <input
                ref="inputs"
                type="checkbox"
                :id="`${id}_${option.value}`"
                :name="name || id"
                :value="option.value"
                :checked="isChecked(option.value)"
                :disabled="disabled"
                :aria-checked="isChecked(option.value)"
                @change="onChange($event, option.value)"
            />

            <span :class="valueClass">
                {{ option.label }}
            </span>
        </label>

        <p v-if="hasError" :id="`${id}-error`" :class="errorClass" role="alert">
            {{ errorMessage }}
        </p>
    </div>
</template>

<script setup lang="ts">
defineOptions({ name: "CheckboxGroup" });

import { computed, ref } from "vue";

interface CheckboxOption {
    value: string;
    label: string;
}

const props = withDefaults(
    defineProps<{
        modelValue: string[];
        id: string;
        name?: string;
        options: CheckboxOption[];
        disabled?: boolean;
        error?: string | string[];

        /* CSS hooks */
        rootClass?: string;
        labelClass?: string;
        valueClass?: string;
        errorClass?: string;
    }>(),
    {
        rootClass: "checkbox-group",
        labelClass: "checkbox-group__label",
        valueClass: "checkbox-group__value",
        errorClass: "form__error",
    }
);

const emit = defineEmits<{
    (e: "update:modelValue", value: string[]): void;
}>();

const inputs = ref<HTMLInputElement[]>([]);

const hasError = computed(() =>
    Array.isArray(props.error) ? props.error.length > 0 : !!props.error
);

const errorMessage = computed(() =>
    Array.isArray(props.error) ? props.error[0] : props.error
);

function isChecked(value: string): boolean {
    return props.modelValue.includes(value);
}

function onChange(event: Event, value: string) {
    const target = event.target as HTMLInputElement;
    const next = [...props.modelValue];

    if (target.checked) {
        if (!next.includes(value)) next.push(value);
    } else {
        const idx = next.indexOf(value);
        if (idx !== -1) next.splice(idx, 1);
    }

    emit("update:modelValue", next);
}

/* expose helpers */
defineExpose({
    focusFirst: () => inputs.value?.[0]?.focus(),
});
</script>
