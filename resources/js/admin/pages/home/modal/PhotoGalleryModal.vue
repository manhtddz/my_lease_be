<script setup lang="ts">
interface Props {
  id: string;
  images: { src: string; alt: string; width?: number; height?: number }[];
}

const props = defineProps<Props>();
</script>

<template>
  <div :id="props.id" class="modal photogallery" aria-hidden="true">
    <div class="photogallery__overlay" tabindex="-1">
      <div
        class="photogallery__container"
        role="dialog"
        aria-modal="true"
        aria-label="Photo Gallery"
        :data-modalgalleryclose="props.id"
      >
        <div class="pagination">
          <span data-slidecurrent></span>
          <span>of</span>
          <span data-slidelength></span>
        </div>

        <section
          class="splide slide is-photogallery"
          role="group"
          aria-label="Photo Gallery Slide"
          data-slider="photogallery"
          :data-modalclose="props.id"
        >
          <div class="splide__track">
            <ul class="splide__list">
              <li
                v-for="(img, i) in props.images"
                :key="i"
                class="splide__slide"
              >
                <img
                  :src="img.src"
                  :alt="img.alt"
                  :width="img.width || 960"
                  :height="img.height || 720"
                  loading="lazy"
                />
              </li>
            </ul>
          </div>
        </section>

        <footer class="photogallery__footer">
          <button
            type="button"
            class="btn is-type1 icon-request"
          >
            <span class="is-label">Request a tour</span>
          </button>
          <a href="/contact" class="btn is-type2">
            <span class="is-label">Request to apply</span>
          </a>
        </footer>
      </div>

      <button
        type="button"
        class="photogallery__close"
        aria-label=" Photo Gallery Close"
        :data-modalgallerybtnclose="props.id"
      ></button>
    </div>
  </div>
</template>
