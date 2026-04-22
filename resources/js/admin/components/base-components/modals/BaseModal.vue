<template>
    <div v-if="show" class="modal">
        <div class="modal__overlay" tabindex="-1" @click="$emit('update:show', false)">
            <section
                class="modal__container"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modaltitle"
                @click.stop
            >
                <header class="modal__header">
                    <slot name="header"></slot>
                </header>

                <div class="modal__body">
                    <slot name="body"></slot>
                </div>

                <footer class="modal__footer">
                    <slot name="footer"></slot>
                </footer>
            </section>
        </div>
    </div>
</template>

<script setup lang="ts">
const props = defineProps<{ show: boolean }>()
const emit = defineEmits(["update:show"])
</script>

