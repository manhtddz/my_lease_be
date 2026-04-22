<template>
  <footer class="property__footer">
    <button type="button" class="btn is-type1 icon-request" @click.prevent="$emit('open-form')">
      <span class="is-label">Request a tour</span>
    </button>
    <a href="/contact" class="btn is-type2"><span class="is-label">Request to apply</span></a>
  </footer>
</template>

<script setup lang="ts">
// Emits: open-form
</script>
