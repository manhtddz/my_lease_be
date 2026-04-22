<template>
    <main>
        <router-view />
    </main>
</template>
<script setup lang="ts">
import { useMainStore } from "@/admin/stores/main";
const main = useMainStore();
</script>
