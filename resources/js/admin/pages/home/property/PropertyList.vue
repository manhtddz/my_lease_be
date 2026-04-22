<script setup lang="ts">
import PropertyCard from '@admin/components/blocks/Card.vue'
import { usePropertyModal } from '@admin/composable/usePropertyModal'

const { items, activeId } = defineProps<{ items: any[]; activeId?: number | string | null }>()
const { openModal } = usePropertyModal()
</script>

<template>
    <ul class="home__results--list">
        <li v-for="item in items" :key="item.id"
            @mouseenter="() => { $emit('hover-property', item.id) }"
            @mouseleave="() => { $emit('leave-property', item.id) }">
            <PropertyCard
                v-bind="item"
                :show="true"
                :active="item.id === activeId"
                @click="openModal(item.id)"
            />
        </li>
    </ul>
</template>

