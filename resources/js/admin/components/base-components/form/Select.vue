<template>
    <div
        ref="root"
        class="selectbox"
        :class="[rootClass, { 'is-disabled': disabled, 'is-open': open, 'has-error': hasError }]"
    >
        <!-- Trigger -->
        <button
            type="button"
            class="selectbox-trigger"
            :class="triggerClass"
            :id="id"
            :aria-expanded="open ? 'true' : 'false'"
            aria-haspopup="listbox"
            :aria-disabled="disabled ? 'true' : 'false'"
            :disabled="disabled"
            @click="onTriggerClick"
            @keydown.enter.prevent="onTriggerClick"
            @keydown.space.prevent="onTriggerClick"
        >
            <span class="is-label" :class="{ 'is-placeholder': !modelValue }">
                {{ displayValue }}
            </span>

            <span class="is-arrow" :class="{ 'is-open': open }">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>

            <span
                v-if="clearable && modelValue"
                class="is-clear"
                @click.stop="clear"
            >
                ×
            </span>
        </button>

        <!-- Dropdown -->
        <Transition name="dropdown">
            <div
                v-show="open"
                class="selectbox-dropdown"
                :class="dropdownClass"
                role="presentation"
                @click.stop
            >
                <ul
                    ref="listEl"
                    role="listbox"
                    class="selectbox-list"
                    :class="listClass"
                    tabindex="0"
                    @keydown.escape.prevent="close"
                >
                    <li
                        v-if="!normalizedOptions.length"
                        class="selectbox-empty"
                        aria-disabled="true"
                    >
                        No options
                    </li>

                    <li
                        v-for="(opt, i) in normalizedOptions"
                        :key="opt.value"
                        role="option"
                        class="selectbox-item"
                        :class="[itemClass, { 'is-selected': opt.value === modelValue }]"
                        :aria-selected="opt.value === modelValue"
                        tabindex="-1"
                        @click="select(opt.value)"
                        @keydown.enter.prevent="select(opt.value)"
                        @keydown.space.prevent="select(opt.value)"
                        @keydown.arrow-down.prevent="focusNext(i)"
                        @keydown.arrow-up.prevent="focusPrev(i)"
                    >
                        {{ opt.label }}
                    </li>
                </ul>
            </div>
        </Transition>
    </div>
</template>

<script setup lang="ts">
defineOptions({ name: "Select" });

import {
    ref,
    computed,
    watch,
    onMounted,
    onBeforeUnmount,
    nextTick,
} from "vue";

interface Option {
    value: string;
    label: string;
}

interface Props {
    id: string;
    placeholder: string;
    options?: string[] | Option[];
    modelValue?: string;
    open: boolean;
    disabled?: boolean;
    clearable?: boolean;
    hasError?: boolean;

    /* Optional CSS hooks */
    rootClass?: string;
    triggerClass?: string;
    dropdownClass?: string;
    listClass?: string;
    itemClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
    options: () => [],
    disabled: false,
    clearable: false,
    hasError: false,
});

const emit = defineEmits<{
    (e: "update:modelValue", value: string): void;
    (e: "update:open", value: boolean): void;
}>();

const root = ref<HTMLDivElement | null>(null);
const listEl = ref<HTMLUListElement | null>(null);

/* -----------------------------
 * Normalize options
 * ----------------------------- */
const normalizedOptions = computed<Option[]>(() =>
    props.options.map((opt) =>
        typeof opt === "string" ? { value: opt, label: opt } : opt
    )
);

/* -----------------------------
 * Display value
 * ----------------------------- */
const displayValue = computed(() => {
    if (!props.modelValue) return props.placeholder;

    return (
        normalizedOptions.value.find((o) => o.value === props.modelValue)
            ?.label ?? props.modelValue
    );
});

/* -----------------------------
 * Open / Close
 * ----------------------------- */
const onTriggerClick = () => {
    if (props.disabled) return;
    emit("update:open", !props.open);
};

const close = () => emit("update:open", false);

/* -----------------------------
 * Select / Clear
 * ----------------------------- */
const select = (value: string) => {
    emit("update:modelValue", value);
    close();
};

const clear = () => {
    emit("update:modelValue", "");
    close();
};

/* -----------------------------
 * Focus helpers
 * ----------------------------- */
const focusIndex = (idx: number) => {
    const items = listEl.value?.querySelectorAll<HTMLLIElement>(
        ".selectbox-item"
    );
    if (!items?.length) return;

    const target = items[Math.max(0, Math.min(idx, items.length - 1))];
    target.focus();
    target.scrollIntoView({ block: "nearest" });
};

const focusNext = (idx: number) => focusIndex(idx + 1);
const focusPrev = (idx: number) => focusIndex(idx - 1);

/* -----------------------------
 * Click outside
 * ----------------------------- */
const onClickOutside = (e: MouseEvent) => {
    if (!props.open) return;
    if (root.value && !root.value.contains(e.target as Node)) {
        close();
    }
};

/* -----------------------------
 * Auto focus when open
 * ----------------------------- */
watch(
    () => props.open,
    async (isOpen) => {
        if (isOpen && normalizedOptions.value.length) {
            await nextTick();
            focusIndex(0);
        }
    }
);

onMounted(() => {
    document.addEventListener("click", onClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener("click", onClickOutside);
});
</script>
