<template>
  <div :id="`property${props.property.id}`" class="modal property" aria-hidden="true">
    <div class="property__overlay" :data-propertyclose="`property${props.property.id}`">
      <div class="property__container" role="dialog" aria-modal="true" :aria-labelledby="`property${props.property.id}title`">

        <!-- Property Details View -->
        <div id="property" class="property__contents is-property" :aria-hidden="isShowingGallery">
          <PropertyHeader mode="details" :property-id="props.property.id" />

          <PropertyPhotos :property="props.property" @open-gallery="showGallery" />

          <PropertySummary :property="props.property" />

          <PropertyFeatures :property="props.property" />

          <PropertyFooter @open-form="emit('open-form')" />
        </div>

        <!-- Photo Gallery View -->
        <div class="property__contents is-allphoto" :aria-hidden="!isShowingGallery">
          <PropertyHeader mode="gallery" :property-id="props.property.id" @back="hideGallery" />

          <PropertyGallery v-if="isShowingGallery" :property="props.property" />

          <PropertyFooter @open-form="emit('open-form')" />
        </div>

      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import PropertyHeader from '@admin/pages/home/property/components/PropertyHeader.vue'
import PropertyPhotos from '@admin/pages/home/property/components/PropertyPhotos.vue'
import PropertySummary from '@admin/pages/home/property/components/PropertySummary.vue'
import PropertyFeatures from '@admin/pages/home/property/components/PropertyFeatures.vue'
import PropertyFooter from '@admin/pages/home/property/components/PropertyFooter.vue'
import PropertyGallery from '@admin/pages/home/property/components/PropertyGallery.vue'

interface Property {
  id: number;
  view_id: string;
  hp_title: string;
  amount: string;
  public_address_en: string;
  bed_count: number;
  bath_room_count: number;
  building_area_sqft: number;
  room_images: string[];
  movein_status: number;
  location: string;
  type: string;
  inspection: string;
  number_of_floors: number;
  number_of_parking: number;
  environment: string;
  fixtures: string;
  pet_status: string;
  high_school: string;
  middle_school: string;
  elementary_school: string;
  parking_space_type: string;
  available_date: string;
  pet_detail: string;
  appliances?: string;
}

const props = defineProps<{
  property: Property
}>()
const emit = defineEmits<{ (e: 'open-form'): void }>()
const isShowingGallery = ref(false)
const showGallery = () => { isShowingGallery.value = true }
const hideGallery = () => { isShowingGallery.value = false }
</script>

