<template>
  <Teleport to="body">
    <Transition name="fade">
      <div v-if="visible" class="confirm-backdrop" @click.self="onCancel">
        <div class="confirm-modal">
          <h3 class="confirm-title">{{ title }}</h3>

          <div class="confirm-content">
            <slot>
              {{ message }}
            </slot>
          </div>

          <div class="confirm-actions">
            <button class="btn btn-cancel" @click="onCancel">
              {{ cancelText }}
            </button>
            <button class="btn btn-confirm" @click="onConfirm" :disabled="loading">
              <span v-if="loading">...</span>
              <span v-else>{{ confirmText }}</span>
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'

interface Props {
  modelValue: boolean
  title?: string
  message?: string
  confirmText?: string
  cancelText?: string
  loading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Xác nhận',
  message: 'Bạn có chắc chắn muốn thực hiện hành động này?',
  confirmText: 'Đồng ý',
  cancelText: 'Hủy',
  loading: false,
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void
  (e: 'confirm'): void
  (e: 'cancel'): void
}>()

const visible = ref(props.modelValue)

watch(
  () => props.modelValue,
  v => (visible.value = v)
)

function close() {
  emit('update:modelValue', false)
}

function onConfirm() {
  emit('confirm')
}

function onCancel() {
  emit('cancel')
  close()
}
</script>

<style scoped>
.confirm-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.confirm-modal {
  background: #fff;
  min-width: 320px;
  max-width: 420px;
  border-radius: 8px;
  padding: 20px;
}

.confirm-title {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 12px;
}

.confirm-content {
  font-size: 14px;
  margin-bottom: 20px;
}

.confirm-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

.btn {
  padding: 6px 14px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-cancel {
  background: #eee;
}

.btn-confirm {
  background: #2563eb;
  color: #fff;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.15s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
