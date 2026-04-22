<script setup lang="ts">
import { computed } from "vue";
import Button from "../base-components/button/Button.vue";

interface Props {
    modelValue: Record<string, any>;

    formClass?: string;
    actionsClass?: string;
    searchButtonClass?: string;
    resetButtonClass?: string;
}

const props = defineProps<Props>();

const emit = defineEmits<{
    (e: "update:modelValue", value: Record<string, any>): void;
    (e: "search"): void;
}>();

const model = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

function onSubmit() {
    emit("search");
}

function onReset() {
    const resetValue: Record<string, any> = {};

    Object.keys(props.modelValue).forEach((key) => {
        resetValue[key] = null;
    });

    emit("update:modelValue", resetValue);
    emit("search");
}
</script>

<template>
    <form :class="formClass" @submit.prevent="onSubmit">
        <slot />

        <div :class="actionsClass">
            <Button
                label="Search"
                :inputClass="searchButtonClass"
                @click="onSubmit"
            />

            <Button
                label="Reset"
                :inputClass="resetButtonClass"
                @click="onReset"
            />
        </div>
    </form>
</template>
