<script setup lang="ts">
import { computed, onMounted, nextTick } from 'vue'
import Splide from '@splidejs/splide'
import config from '@admin/config/config'

interface Props {
  id: number
  view_id: string
  hp_title?: string
  amount?: string
  property?: object
  bed_count?: string
  bath_room_count?: string
  building_area_sqft?: string
  room_images?: string[]
  movein_status?: number
  location?: string
  inspection?: number
  active?: boolean
}

const emit = defineEmits(['click'])

const locationList = computed(() => {
  return props.location ? props.location.split(',') : [];
});

defineOptions({ inheritAttrs: false })
const props = defineProps<Props>()


onMounted(async () => {
  if (!props.room_images || props.room_images.length === 0) return;

  await nextTick();

  const instance = new Splide(`#splide-${props.id}`, {
    type: 'fade',
    speed: 2000,
    perPage: 1,
    autoplay: props.room_images.length > 1,
    arrows: props.room_images.length > 1,
    pagination: props.room_images.length > 1,
    easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
    interval: 4000,
    rewind: true,
  }).mount();

  // Prevent clicks within Splide controls from bubbling to the anchor trigger
  try {
    const root = instance.root as HTMLElement;
    const stop = (e: Event) => e.stopPropagation();
    root.querySelectorAll('.splide__arrow, .splide__pagination__page').forEach((el) => {
      el.addEventListener('click', stop);
    });
  } catch (_) {
    // no-op safeguard
  }
});

</script>

<template>
  <li :class="['home__results--item', { 'is-active': props.active }]">
    <a :href="`#property${props.id}`" class="home__results--trigger" aria-label="Detail Open" data-propertymodal  @click.prevent="$emit('click')">
      <div class="home__results--photo media-frame">
        <ul class="home__results--tags">
            <li
                class="home__results--taglabel"
                :class="`is-${config.moveinStatus.color[Number(movein_status)]}`"
              >
                {{ config.moveinStatus.text[Number(movein_status)] }}
            </li>

            <li class="home__results--taglabel is-status4" v-if="props.inspection == 0">
              Non-Inspection
            </li>

            <li
                v-for="(loc, index) in locationList"
                :key="`loc-${index}`"
                class="home__results--taglabel is-status5"
              >
                {{ config.location.text[Number(loc)] }}
            </li>
        </ul>
        <div v-if="(props.room_images?.length || 0) > 0" :class="['splide','slide','media-inner', { 'is-single': (props.room_images?.length || 0) <= 1 }]" role="group" aria-label="Photo Slide" data-slider="single" :id="`splide-${props.id}`">
          <div class="splide__track">
            <ul class="splide__list">
              <li v-for="(img, i) in props.room_images" :key="i" class="splide__slide">
                <img :src="img" :alt="`Photo ${i+1}`" class="media-img" width="360" height="188" loading="lazy" />
              </li>
            </ul>
          </div>
        </div>
        <div v-else class="media-fallback">
          <img src="/assets/images/no-image.svg" alt="No image" class="media-img" width="360" height="188" loading="lazy" />
        </div>
      </div>


      <div class="home__results--summary">
        <h3 class="title is-msize">{{ props.hp_title }}</h3>
        <p class="home__results--yen">¥{{ props.amount }}</p>
        <address v-if="props.property?.public_address_en" class="home__results--address">
          <span class="text is-ssize">{{ props.property.public_address_en }}</span>
        </address>
        <div class="home__results--info">
          <ul class="home__results--infolist">
            <li class="home__results--infoitem is-bed">
              <span class="is-label">{{ props.bed_count }} Beds</span>
            </li>
            <li class="home__results--infoitem is-bath">
              <span class="is-label">{{ props.bath_room_count }} Baths</span>
            </li>
            <li class="home__results--infoitem is-sqft">
              <span class="is-label">{{ props.building_area_sqft }} sqft</span>
            </li>
          </ul>
        </div>
        <p class="home__results--id">
          <span class="text is-ssize">[ ID:{{ props.view_id }} ]</span>
        </p>
      </div>
    </a>
  </li>
</template>

<style scoped>
.home__results--item.is-active {
  border: 3px solid #d4af37;
  border-radius: 10px;
  max-width: none !important;
  overflow: hidden;
}
/* Media sizing via classes instead of inline styles */
.media-frame {
  min-width: 335px;
  width: 335px;
}
.media-inner { width: 335px; }
.media-img { display: block; width: 100%; height: 188px; object-fit: cover; }
.media-fallback { min-width: 335px; border-top-left-radius: 10px; border-top-right-radius: 10px; overflow: hidden; }
</style>
