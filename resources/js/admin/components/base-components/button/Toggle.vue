<script setup lang="ts">
import { computed } from "vue";

type ToggleValue = string | number | boolean;

interface Props {
    modelValue: ToggleValue;
    onValue: ToggleValue;
    offValue: ToggleValue;
    disabled?: boolean;
    rootClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
    disabled: false,
});

const emit = defineEmits<{
    (e: "update:modelValue", value: ToggleValue): void;
    (e: "change", value: ToggleValue): void;
}>();

const isOn = computed(() => props.modelValue === props.onValue);

function toggle() {
    if (props.disabled) return;

    const next = isOn.value ? props.offValue : props.onValue;
    emit("update:modelValue", next);
    emit("change", next);
}
</script>

<template>
    <div
        :class="rootClass"
        role="switch"
        :aria-checked="isOn"
        :aria-disabled="disabled"
        tabindex="0"
        @click="toggle"
        @keydown.enter.prevent="toggle"
        @keydown.space.prevent="toggle"
    >
        <slot :isOn="isOn" />
    </div>
</template>
