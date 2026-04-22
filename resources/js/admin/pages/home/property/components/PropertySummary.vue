<template>
  <section class="property__section">
    <header class="property__head">
      <p class="property__head--id"><span class="text">[ ID:{{ property.view_id }} ]</span></p>
      <h2 :id="`property${property.id}title`" class="property__head--title">{{ property.hp_title }}</h2>
      <address v-if="property.property?.public_address_en"  class="property__head--address"><span class="text">{{ property.property?.public_address_en }}</span></address>
    </header>

    <ul class="property__summary">
      <li class="property__summary--item">
        <span class="property__summary--label">Rent</span>
        <span class="property__summary--yen">¥{{ property.amount ?? 0 }}</span>
      </li>
      <li v-if="property.areas?.length" class="property__summary--item">
        <span class="property__summary--label">Area</span>
        <span class="property__summary--text">
          {{ property.areas.map(a => a.name_en).join(', ') }}
        </span>
      </li>
      <li v-if="property.base_nearest" class="property__summary--item">
        <span class="property__summary--label">Nearest Base</span>
        <span class="property__summary--text">{{ property.base_nearest }} minutes by car </span>
      </li>
      <li v-if="property.inspection || property.inspection == 0" class="property__summary--item">
        <span class="property__summary--label">Inspection</span>
        <span class="property__summary--text">{{ config.inspection.text[Number(property.inspection)] }}</span>
      </li>
    </ul>

    <ul class="property__primaryinfo">
      <li class="property__primaryinfo--item is-buildtype">
        <span class="is-accessibility">Property Type</span>
        <span class="is-label">{{ config.propertyType.text[Number(property.type)] }}</span>
      </li>
      <li class="property__primaryinfo--item is-bed">
        <span class="is-accessibility">Bed Rooms</span>
        <span class="is-label">{{ property.bed_count }}</span>
      </li>
      <li class="property__primaryinfo--item is-bths">
        <span class="is-accessibility">Bath Rooms</span>
        <span class="is-label">{{ property.bath_room_count }}</span>
      </li>
      <li class="property__primaryinfo--item is-sqft">
        <span class="is-accessibility">SQFT</span>
        <span v-if="property.building_area_sqft" class="is-label">{{ property.building_area_sqft }} sqft</span>
      </li>
      <li class="property__primaryinfo--item is-parking">
        <span class="is-accessibility">Parking</span>
        <span class="is-label">{{ property.number_of_parking }}</span>
      </li>
      <li class="property__primaryinfo--item is-floors">
        <span class="is-accessibility">Floors</span>
        <span class="is-label">{{ property.number_of_floors }}</span>
      </li>
    </ul>

    <ul class="property__secondaryinfo">
      <li
        v-for="(env, index) in environmentList"
        :key="`env-${index}`"
        :class="`property__secondaryinfo--item ${config.environment.class[Number(env)]}`"
      >
        <span class="is-label">{{ config.environment.text[Number(env)] }}</span>
      </li>
      <li
        v-for="(loc, index) in locationList"
        :key="`loc-${index}`"
        :class="`property__secondaryinfo--item ${config.location.class[Number(loc)]}`"
      >
        <span class="is-label">{{ config.location.text[Number(loc)] }}</span>
      </li>
      <li
        v-for="(fixt, index) in fixturesList"
        :key="`fixt-${index}`"
        :class="`property__secondaryinfo--item ${config.fixtures.class[Number(fixt)]}`"
      >
        <span class="is-label">{{ config.fixtures.text[Number(fixt)] }}</span>
      </li>
    </ul>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import config from '@admin/config/config'

const props = defineProps<{ property: any }>()

const locationList = computed(() => (props.property?.location?.split(',') || []).filter(Boolean))
const environmentList = computed(() => (props.property?.environment?.split(',') || []).filter(Boolean))
const fixturesList = computed(() => (props.property?.fixtures?.split(',') || []).filter(Boolean))
</script>
