<script setup lang="ts">
defineOptions({ name: "FormField" });

defineProps<{
    idlabel?: string;
    label?: string;
    error?: string | string[];
    required?: boolean;
    labelClass?: string;
    errorClass?: string;
    fieldClass?: string;
}>();
</script>

<template>
    <div :class="fieldClass">
        <!-- Label -->
        <div v-if="label || $slots.label" class="field-label">
            <slot name="label">
                <label :class="labelClass" :for="idlabel">
                    {{ label }}
                    <span v-if="required" class="required">*</span>
                </label>
            </slot>
        </div>

        <!-- Input -->
        <div class="field-input">
            <slot />
        </div>

        <!-- Validate message -->
        <div v-if="error || $slots.error" class="field-error">
            <slot name="error" :error="error">
                <template v-if="Array.isArray(error)">
                    <div v-for="(msg, i) in error" :key="i">
                        <p :class="errorClass">{{ msg }}</p>
                    </div>
                </template>

                <template v-else>
                    <p :class="errorClass">
                        {{ error }}
                    </p>
                </template>
            </slot>
        </div>
    </div>
</template>
