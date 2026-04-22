<script setup lang="ts">
import { useAttrs } from "vue";

defineOptions({ name: "Input" });

const attrs = useAttrs();

withDefaults(
    defineProps<{
        modelValue?: string | number;
        id?: string;
        name?: string;
        type?: string;
        placeholder?: string;
        required?: boolean;
        disabled?: boolean;
        error?: string;
        inputClass?: string;
    }>(),
    {
        type: "text",
        inputClass: "form_input",
    }
);

const emit = defineEmits<{
    (e: "update:modelValue", value: string | number): void;
    (e: "blur"): void;
    (e: "focus"): void;
}>();

function onInput(event: Event) {
    const target = event.target as HTMLInputElement;
    emit(
        "update:modelValue",
        target.type === "number" ? Number(target.value) : target.value
    );
}
</script>

<template>
    <input
        v-bind="attrs"
        :class="inputClass"
        :type="type"
        :id="id"
        :name="name"
        :placeholder="placeholder"
        :required="required"
        :disabled="disabled"
        :aria-invalid="!!error"
        :aria-describedby="error && id ? `${id}-error` : undefined"
        :value="modelValue"
        @input="onInput"
        @blur="$emit('blur')"
        @focus="$emit('focus')"
    />
</template>
