<script setup lang="ts">
import { useMainStore } from "@/admin/stores/main";
import { computed } from "vue";
import Toggle from "../base-components/button/Toggle.vue";

const mainStore = useMainStore();

const lang = computed({
    get: () => mainStore.locale,
    set: (v: "ja" | "en") => mainStore.setLocale(v),
});
</script>

<template>
    <Toggle
        v-model="lang"
        on-value="ja"
        off-value="en"
        root-class="lang-toggle"
    >
        <template #default="{ isOn }">
            <span class="lang-toggle__item" :class="{ active: isOn }">
                JA
            </span>

            <span class="lang-toggle__item" :class="{ active: !isOn }">
                EN
            </span>
        </template>
    </Toggle>
</template>
