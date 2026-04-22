<template>
  <div v-if="images.length" class="property__gallery-content">
    <div class="property__photoslide">
      <div class="property__photoslide--list">
        <div v-for="(img, i) in images" :key="i" class="property__photoslide--slide">
          <button type="button" class="property__phototrigger">
            <img :src="img" :alt="`Photo ${i + 1}`" width="360" height="240" loading="lazy" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
  property: { id: number; room_images: Array<string | { file_url: string }> }
}>()

const images = computed<string[]>(() => {
  const list = props.property?.room_images || []
  return list.map((it: any) => (typeof it === 'string' ? it : it?.file_url)).filter(Boolean)
})
</script>
