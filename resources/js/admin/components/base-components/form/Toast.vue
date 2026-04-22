<template>
    <div class="custom-toast" :class="type">
        <span v-if="icon" class="icon">{{ icon }}</span>
        <div class="content">
            <p class="message">{{ message }}</p>
            <small v-if="description" class="desc">{{ description }}</small>
        </div>
        <button class="close-btn" @click="$emit('close')">×</button>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    type: 'success' | 'error' | 'info' | 'warning'
    message: string
    description?: string
    icon?: string
}>()

const emit = defineEmits(['close'])
</script>

<style scoped>
.custom-toast {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    min-width: 220px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.custom-toast.success { background: #28a745; }
.custom-toast.error   { background: #dc3545; }
.custom-toast.info    { background: #17a2b8; }
.custom-toast.warning { background: #ffc107; color: #222; }

.message { margin: 0; }
.desc { font-size: 12px; opacity: 0.8; }
.icon { font-size: 18px; }
.close-btn {
    background: transparent;
    border: none;
    font-size: 18px;
    color: inherit;
    cursor: pointer;
}
</style>
