<template>
  <section class="modal__block">
    <button
      v-if="!modelOpen"
      type="button"
      class="modal__addtime--trigger"
      aria-label="Add a time"
      :aria-controls="`add${index}`"
      aria-expanded="false"
      @click="updateOpen(true)"
    >
      <span class="is-label">Add a time</span>
    </button>

    <h2 v-if="index===1" class="title is-msize" v-show="modelOpen">Select up to 3 times</h2>
    <header v-else class="modal__addtime--head" v-show="modelOpen">
      <h2 class="title is-msize">Alternative time</h2>
      <button
        type="button"
        class="modal__delete"
        :aria-controls="`add${index}`"
        aria-label="Delete a time"
        @click="updateOpen(false)"
        data-deletetime
      >
        <img src="/assets/frontend/img/icon/icon-trash.svg" alt="" width="27" height="27" loading="lazy" />
      </button>
    </header>

    <div v-show="modelOpen" :id="`add${index}`" class="modal__addtime">
      <div ref="slideEl" class="splide slide modal__addtime--slide" role="group" aria-label="Photo Slide" data-slider="carousel">
        <div class="splide__track">
          <ul class="splide__list">
            <li v-for="(d,i) in dates" :key="d.iso" class="splide__slide">
              <input
                type="radio"
                :id="`add${index}_date${i}`"
                :name="`add${index}_date`"
                class="modal__addtime--radio"
                :value="d.iso"
                :checked="modelDate === d.iso"
                @change="updateDate(d.iso)"
              />
              <label :for="`add${index}_date${i}`" class="modal__addtime--date">
                <span class="is-week">{{ d.week }}</span>
                <b class="is-day">{{ d.day }}</b>
                <span class="is-month">{{ d.month }}</span>
              </label>
            </li>
          </ul>
        </div>
      </div>

      <div class="modal__addtime--time">
        <ul class="form__btnradio">
          <li v-for="(t,i) in times" :key="t" class="form__btnradio--item">
            <input
              type="radio"
              :id="`add${index}_time${i}`"
              :name="`add${index}_time`"
              class="form__btnradio--radio"
              :value="t"
              :checked="modelTime === t"
              @change="updateTime(t)"
            />
            <label :for="`add${index}_time${i}`" class="form__btnradio--label">{{ t }}</label>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import Splide from '@splidejs/splide'

interface DayItem { iso: string; week: string; day: string; month: string }

const props = defineProps<{
  index: number
  dates: DayItem[]
  times: string[]
  modelValueOpen: boolean
  modelValueDate: string | null
  modelValueTime: string | null
}>()

const emit = defineEmits<{
  (e: 'update:modelValueOpen', value: boolean): void
  (e: 'update:modelValueDate', value: string | null): void
  (e: 'update:modelValueTime', value: string | null): void
}>()

const slideEl = ref<HTMLElement | null>(null)
let splide: Splide | null = null

const modelOpen = computed({
  get: () => props.modelValueOpen,
  set: (v: boolean) => emit('update:modelValueOpen', v)
})
const modelDate = computed({
  get: () => props.modelValueDate,
  set: (v: string | null) => emit('update:modelValueDate', v)
})
const modelTime = computed({
  get: () => props.modelValueTime,
  set: (v: string | null) => emit('update:modelValueTime', v)
})

function updateOpen(v: boolean) { modelOpen.value = v }
function updateDate(v: string | null) { modelDate.value = v }
function updateTime(v: string | null) { modelTime.value = v }

async function mountSlider() {
  if (!slideEl.value) return
  await nextTick()
  if (splide) { try { splide.destroy(true) } catch {} splide = null }
  splide = new Splide(slideEl.value, {
    perPage: 3,
    perMove: 1,
    gap: '8px',
    rewind: false,
    pagination: false,
    arrows: true,
    mediaQuery: 'min',
    breakpoints: { 375: { perPage: 4 } },
  }).mount()
  try {
    const prev = splide.root.querySelector('.splide__arrow--prev') as HTMLButtonElement
    const next = splide.root.querySelector('.splide__arrow--next') as HTMLButtonElement
    ;[prev, next].forEach(btn => btn?.removeAttribute('disabled'))
  } catch {}
}

watch(() => modelOpen.value, (v) => { if (v) mountSlider() })

// If the dates list changes (e.g., holidays loaded asynchronously),
// refresh the slider to reflect the new slides.
watch(() => props.dates.map(d => d.iso).join(','), async () => {
  if (!modelOpen.value) return
  await nextTick()
  try { splide?.destroy(true) } catch {}
  splide = null
  await mountSlider()
})

onMounted(() => { if (modelOpen.value) mountSlider() })

onBeforeUnmount(() => { if (splide) { try { splide.destroy(true) } catch {} splide = null } })
</script>
