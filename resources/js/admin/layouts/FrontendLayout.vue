<template>
    <div>
        <Header v-if="!main.isFilterOpen" />
        <main class="main">
            <router-view />
            <div id="toast-container"></div>
        </main>
        <Footer v-if="!main.isFilterOpen" />
    </div>
    <ConfirmModal
        v-model="visible"
        :title="options.title"
        :message="options.message"
        @confirm="onConfirm"
        @cancel="onCancel"
    />
</template>

<script setup lang="ts">
import Header from "@admin/layouts/frontend/Header.vue";
import Footer from "@admin/layouts/frontend/Footer.vue";
import { useMainStore } from "@/admin/stores/main";
import ConfirmModal from "../components/base-components/modals/ConfirmModal.vue";
import { useConfirm } from "../composable/userConfirm";
const { visible, options, onConfirm, onCancel } = useConfirm()

const main = useMainStore();
</script>
