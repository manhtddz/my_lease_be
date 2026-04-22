<template>
  <section class="property__features">
    <h3 class="property__features--title">Facts & features</h3>

    <section class="property__features--category is-fullwidth">
      <h4 class="property__features--label">Facilities and conditions</h4>
      <div class="property__features--block">
        <h5 class="title is-msize">Appliances / Furniture</h5>
        <ul v-if="appliancesList.length" class="dotlist">
          <li v-for="(app, index) in appliancesList" :key="`app-${index}`" class="dotlist__item">
            {{ config.appliances.text[Number(app)] }}
          </li>
        </ul>
      </div>
      <div class="property__features--block">
        <h5 class="title is-msize">Fixtures & Features</h5>
        <ul v-if="fixturesList.length" class="dotlist">
          <li v-for="(fixture, index) in fixturesList" :key="`fixt-${index}`" class="dotlist__item">
            {{ config.fixtures.text[Number(fixture)] }}
          </li>
        </ul>
      </div>
      <div class="property__features--block">
        <h5 class="title is-msize">Environment / Lifestyle / Permissions</h5>
        <ul v-if="environmentList.length" class="dotlist">
          <li v-for="(env, index) in environmentList" :key="`env-${index}`" class="dotlist__item">
            {{ config.environment.text[Number(env)] }}
          </li>
        </ul>
      </div>
    </section>

    <section class="property__features--category">
      <h4 class="property__features--label">Location</h4>
      <ul v-if="locationList.length" class="dotlist">
        <li v-for="(loc, index) in locationList" :key="`loc-${index}`" class="dotlist__item">
          {{ config.location.text[Number(loc)] }}
        </li>
      </ul>
    </section>

    <section class="property__features--category">
      <h4 class="property__features--label">Distance to base</h4>
      <ul v-if="property.gates?.length" class="dotlist">
          <li v-for="(gate, index) in property.gates" :key="`gate-${index}`" class="dotlist__item">
              {{ gate.base?.name }} {{ gate.name }}: {{ gate.pivot?.time }} min
          </li>
      </ul>
    </section>

    <section class="property__features--category">
      <h4 class="property__features--label">Schools</h4>
      <ul v-if="property.high_school || property.middle_school || property.elementary_school" class="dotlist">
        <li class="dotlist__item">High School : {{ property.high_school }}</li>
        <li class="dotlist__item">Middle School : {{ property.middle_school }}</li>
        <li class="dotlist__item">Elementary School : {{ property.elementary_school }}</li>
      </ul>
    </section>

    <section class="property__features--category">
      <h4 class="property__features--label">Pet Details</h4>
      <ul v-if="petStatusList.length" class="dotlist">
        <li v-for="(pet, index) in petStatusList" :key="`pet-${index}`" class="dotlist__item">
          {{ config.petStatus.text[Number(pet)] }}
        </li>
          <p style="margin-left: 10px;">{{ property.pet_detail }}</p>
      </ul>
    </section>

    <section class="property__features--category">
      <h4 class="property__features--label">Parking Details</h4>
      <ul v-if="property.parking_space_type" class="dotlist">
        <li class="dotlist__item">{{ config.parkingSpaceType.text[Number(property.parking_space_type)] }} {{ property.number_of_parking }} parking spaces</li>
      </ul>
    </section>

    <section class="property__features--category">
      <h4 class="property__features--label">Build Year</h4>
      <ul v-if="property.building_date" class="dotlist">
        <li class="dotlist__item">{{ property.building_date }}</li>
      </ul>
    </section>

    <section class="property__features--category">
      <h4 class="property__features--label">Available Date</h4>
      <ul v-if="property.available_date" class="dotlist">
        <li class="dotlist__item">{{ property.available_date }}</li>
      </ul>
    </section>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import config from '@admin/config/config'

const props = defineProps<{ property: any }>()

const locationList = computed(() => (props.property?.location?.split(',') || []).filter(Boolean))
const environmentList = computed(() => (props.property?.environment?.split(',') || []).filter(Boolean))
const fixturesList = computed(() => (props.property?.fixtures?.split(',') || []).filter(Boolean))
const appliancesList = computed(() => (props.property?.appliances?.split(',') || []).filter(Boolean))
const petStatusList = computed(() => (props.property?.pet_status?.split(',') || []).filter(Boolean))
</script>
