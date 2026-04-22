<template>
    <Radio
        :name="name"
        v-model="modelValue"
        :options="computedOptions"
    />

    <div v-if="useChecked" :id="`${name}-checked`" class="is-checked" />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import Radio from './Radio.vue';
import { Option } from '@/admin/types/common/Option';

const modelValue = defineModel<string | ''>({ default: '' });

const props = withDefaults(defineProps<{
    name: string;
    options: Option[];
    includeAny?: boolean;
    anyLabel?: string;
    useChecked?: boolean;
}>(), {
    includeAny: true,
    anyLabel: 'Any',
    useChecked: true,
});

const computedOptions = computed<Option[]>(() => {
    if (!props.includeAny) return props.options;

    return [
        { label: props.anyLabel, value: '' },
        ...props.options,
    ];
});
</script>
