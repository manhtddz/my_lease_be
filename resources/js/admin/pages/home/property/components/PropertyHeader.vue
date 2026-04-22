<template>
  <header class="property__header">
    <button
      v-if="mode === 'details'"
      type="button"
      class="modal__backlink"
      :data-propertybtnclose="`property${propertyId}`"
    >
      <span class="is-label">Back to search</span>
    </button>
    <button
      v-else
      type="button"
      class="modal__backlink"
      @click="$emit('back')"
    >
      <span class="is-label">Back to listing</span>
    </button>
    <p class="property__logo">
      <span class="property__logo--mark">
        <img src="/assets/frontend/img/common/logo.svg" alt="United Housing Logo" width="40" height="40" />
      </span>
      <span class="property__logo--label">United Housing</span>
    </p>
  </header>
</template>

<script setup lang="ts">
const props = defineProps<{
  mode: 'details' | 'gallery'
  propertyId: number
}>()
</script>
