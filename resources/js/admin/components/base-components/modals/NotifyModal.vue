<template>
    <Teleport to="body">
        <BaseModal v-model:show="show">
            <template #header>
                <button type="button" class="modal__close" @click="show = false" aria-label="Close"></button>
            </template>

            <template #body>
                <div class="modal__block">
                    <h2 id="modaltitle" class="title is-lsize modal__thankstitle">
                        Thank you for reaching out!
                    </h2>

                    <p class="text">
                        We’ve received your message and will get back to you as soon as possible.<br />
                        If your inquiry is urgent, feel free to contact us directly.<br />
                        We appreciate your interest and look forward to assisting you!
                    </p>
                </div>

                <div class="modal__block">
                    <h3 class="modal__thankstel">
                        <span class="is-label">Need help?</span>
                    </h3>
                    <a href="tel:{{ settings.tel_en }}" class="btn is-type2">
                        <span class="is-label">Call us at {{ settings.tel_en }}</span>
                    </a>
                </div>
            </template>

            <template #footer>
                <a href="/" class="modal__backlink">
                    <span class="is-label">Back to HOME</span>
                </a>
            </template>
        </BaseModal>
    </Teleport>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import BaseModal from './BaseModal.vue'
import axios from 'axios'

const props = defineProps<{ modelValue: boolean }>()
const emit = defineEmits(['update:modelValue'])

const show = ref(props.modelValue)
watch(() => props.modelValue, v => show.value = v)
watch(show, v => emit('update:modelValue', v))

const settings = ref<any>(null)
onMounted(async () => {
    try {
        const { data } = await axios.get('/api/v1/settings')
        settings.value = data
    } catch (e) {
        console.error('Failed to load settings', e)
    }
})
</script>
