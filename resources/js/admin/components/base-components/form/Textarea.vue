<template>
    <div :class="rootClass">
        <textarea
            ref="textareaRef"
            :id="id"
            :name="name"
            :value="modelValue ?? ''"
            :placeholder="placeholder"
            :rows="rows"
            :cols="cols"
            :maxlength="maxlength"
            :required="required"
            :disabled="disabled"
            :readonly="readonly"
            :autofocus="autofocus"
            :class="[
                textareaClass,
                {'is-disabled': disabled },
            ]"
            @input="onInput"
            @blur="$emit('blur')"
            @focus="$emit('focus')"
        />
    </div>
</template>

<script setup lang="ts">
defineOptions({ name: "Textarea" });

import { computed, ref, onMounted } from "vue";

const props = withDefaults(
    defineProps<{
        modelValue?: string | null;
        id: string;
        name?: string;
        placeholder?: string;
        rows?: number;
        cols?: number;
        maxlength?: number;
        required?: boolean;
        disabled?: boolean;
        readonly?: boolean;
        autofocus?: boolean;
        error?: string | string[];

        /* CSS hooks */
        rootClass?: string;
        textareaClass?: string;
        errorClass?: string;
    }>(),
    {
        rows: 4,
        cols: 40,
    }
);

const emit = defineEmits<{
    (e: "update:modelValue", value: string): void;
    (e: "blur"): void;
    (e: "focus"): void;
}>();

const textareaRef = ref<HTMLTextAreaElement | null>(null);

function onInput(e: Event) {
    emit("update:modelValue", (e.target as HTMLTextAreaElement).value);
}

/* expose DOM helpers */
defineExpose({
    focus: () => textareaRef.value?.focus(),
    blur: () => textareaRef.value?.blur(),
});
</script>
