<template>
  <div class="property__photo">
    <div
      v-if="imageCount > 1"
      class="splide slide"
      role="group"
      aria-label="Photo Slide"
      data-slider="property"
      :id="`splide-property-${property.id}`"
    >
      <div class="splide__track">
        <ul class="splide__list">
          <li v-for="(img, i) in normalizedImages" :key="i" class="splide__slide">
            <img :src="img" :alt="`Photo ${i + 1}`" width="960" height="720" loading="lazy" />
          </li>
        </ul>
      </div>
    </div>

    <div v-else-if="imageCount === 1" class="property__photo--single">
      <img :src="normalizedImages[0]" alt="Photo 1" width="960" height="720" loading="lazy" />
    </div>

    <button
      v-if="imageCount > 0"
      type="button"
      class="property__photo--trigger"
      aria-label="All Photos Open"
      @click="$emit('open-gallery')"
    >
      <span class="is-label">All Photos ({{ imageCount }})</span>
    </button>
  </div>
</template>

<script setup lang="ts">
import { onBeforeUnmount, onMounted, nextTick, computed, watch } from 'vue'
import Splide from '@splidejs/splide'

interface Property {
  id: number
  room_images: Array<string | { file_url: string }>
}

const props = defineProps<{
  property: Property
}>()

let splideInstance: Splide | null = null

const normalizedImages = computed<string[]>(() => {
  const list = props.property?.room_images || []
  return list.map((it: any) => (typeof it === 'string' ? it : it?.file_url)).filter(Boolean)
})

const imageCount = computed(() => normalizedImages.value.length)

async function mountSplideIfNeeded() {
  if (splideInstance) {
    try { splideInstance.destroy(true) } catch {}
    splideInstance = null
  }
  if (imageCount.value > 1) {
    await nextTick()
    const instance = new Splide(`#splide-property-${props.property.id}`, {
      type: 'fade',
      speed: 2000,
      perPage: 1,
      autoplay: true,
      arrows: true,
      pagination: true,
      easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
      interval: 4000,
      rewind: true,
    }).mount()
    splideInstance = instance
    try { instance.root.classList.add('is-overflow') } catch {}
  }
}

onMounted(() => {
  mountSplideIfNeeded()
})

watch(
  () => [props.property?.id, imageCount.value],
  () => { mountSplideIfNeeded() }
)

onBeforeUnmount(() => {
  if (splideInstance) {
    try { splideInstance.destroy(true) } catch {}
    splideInstance = null
  }
})
</script>
