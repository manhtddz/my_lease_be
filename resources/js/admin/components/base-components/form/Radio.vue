<template>
    <div>
        <label v-for="opt in options" :key="opt.value" :class="labelClass">
            <input
                type="radio"
                :name="name"
                :value="opt.value"
                :checked="modelValue === opt.value"
                :disabled="disabled"
                @change="$emit('update:modelValue', opt.value)"
            />
            <span :class="valueClass">{{ opt.label }}</span>
        </label>
    </div>
</template>

<script setup lang="ts">
import { Option } from '@/admin/types/common/Option';

defineOptions({ name: "Radio" });

defineProps<{
    modelValue?: string | number | "";
    name: string;
    options: Option[];
    disabled?: boolean;
    labelClass?: string;
    valueClass?: string;
}>();

defineEmits<{
    (e: "update:modelValue", value: string | number | ""): void;
}>();
</script>
