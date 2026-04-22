<script setup lang="ts">
import { computed, useAttrs } from "vue";

interface Props {
    type?: "button" | "submit" | "reset";
    icon?: string;
    label: string;
    variant?: "primary" | "secondary" | "danger";
    disabled?: boolean
    inputClass?: string
}

const props = withDefaults(defineProps<Props>(), {
    type: 'button',
    variant: 'primary',
    disabled: false,
});

const attrs = useAttrs();

const buttonClass = computed(() => [
    "btn",
    `btn-${props.variant}`,
    props.icon && `icon-${props.icon}`,
    props.inputClass,
]);
</script>

<template>
    <button :type="type" :disabled="disabled" :class="buttonClass">
        <span class="is-label">{{ label }}</span>
    </button>
</template>
