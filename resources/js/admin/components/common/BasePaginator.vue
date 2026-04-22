<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
    page: number;
    perPage: number;
    total: number;

    rootClass?: string;
    controlsClass?: string;
    buttonClass?: string;
    activeButtonClass?: string;
    ellipsisClass?: string;
}>();

const emit = defineEmits<{
    (e: "change", page: number): void;
}>();

const totalPages = computed(() => Math.ceil(props.total / props.perPage));

const startItem = computed(() => {
    if (props.total === 0) return 0;
    return (props.page - 1) * props.perPage + 1;
});

const endItem = computed(() =>
    Math.min(props.page * props.perPage, props.total)
);

function goTo(page: number) {
    if (page < 1 || page > totalPages.value) return;
    emit("change", page);
}

const visiblePages = computed<(number | string)[]>(() => {
    const pages: (number | string)[] = [];
    const current = props.page;
    const total = totalPages.value;

    if (total <= 7) {
        for (let i = 1; i <= total; i++) pages.push(i);
        return pages;
    }

    pages.push(1);

    if (current > 3) pages.push("...");

    const start = Math.max(2, current - 1);
    const end = Math.min(total - 1, current + 1);

    for (let i = start; i <= end; i++) pages.push(i);

    if (current < total - 2) pages.push("...");

    pages.push(total);

    return pages;
});
</script>

<template>
    <div :class="rootClass">
        <!-- SLOT INFO -->
        <slot
            name="info"
            :page="page"
            :per-page="perPage"
            :total="total"
            :start-item="startItem"
            :end-item="endItem"
            :total-pages="totalPages"
        />

        <!-- CONTROLS -->
        <div v-if="totalPages > 1" :class="controlsClass">
            <button
                :class="buttonClass"
                :disabled="page === 1"
                @click="goTo(page - 1)"
            >
                ‹ Trước
            </button>

            <template v-for="p in visiblePages" :key="p">
                <button
                    v-if="typeof p === 'number'"
                    :class="[
                        buttonClass,
                        { [activeButtonClass || '']: p === page },
                    ]"
                    @click="goTo(p)"
                >
                    {{ p }}
                </button>

                <span v-else :class="ellipsisClass">
                    {{ p }}
                </span>
            </template>

            <button
                :class="buttonClass"
                :disabled="page === totalPages"
                @click="goTo(page + 1)"
            >
                Sau ›
            </button>
        </div>
    </div>
</template>
