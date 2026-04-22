<script setup lang="ts">
import Button from "@/admin/components/base-components/button/Button.vue";
import Toggle from "@/admin/components/base-components/button/Toggle.vue";
import LanguageSwitcher from "@/admin/components/lang/LanguageSwitcher.vue";
import { useConfirm } from "@/admin/composable/userConfirm";
import { useAuthStore } from "@/admin/stores/auth";
import { onMounted, onUnmounted, ref } from "vue";
const authStore = useAuthStore();
const { confirm }  = useConfirm()

const isMobile = ref(false);

const isNavOpen = ref(false);

function toggleNav() {
    isNavOpen.value = !isNavOpen.value;
}

function checkIsMobile() {
    isMobile.value = window.innerWidth <= 1024;
}

async function handleLogout() {
    const ok = await confirm({
        title: "Đăng xuất",
        message: "Bạn chắc chắn?",
    });

    if (!ok) return;

    authStore.logout()
}

onMounted(() => {
    checkIsMobile()
    window.addEventListener('resize', checkIsMobile)
})
</script>

<template>
    <!-- MARK:HEADER -->
    <header class="header">
        <div class="header__container">
            <p class="header__logo">
                <a href="/" class="header__logo--link">
                    <span class="header__logo--mark"><img src="/assets/frontend/img/common/logo.svg" alt="United Housing Logo" width="40" height="40"></span>
                    <span class="header__logo--label">United Housing</span>
                </a>
            </p>
            <button
                type="button"
                class="header__navtrigger"
                aria-controls="navigation"
                :aria-expanded="isNavOpen"
                aria-label="Menu Open"
                @click="toggleNav"
                data-gnavtrigger
            >
                <span></span>
            </button>
            <nav
                id="navigation"
                class="gnav"
                aria-label="Main Navigation"
                v-show="!isMobile || isNavOpen"
                :aria-hidden="isMobile && !isNavOpen"
                :class="{ 'is-open': isNavOpen }"
            >
                <ul class="gnav__list">
                    <li class="gnav__item"><router-link to="/" class="gnav__link">Home</router-link></li>
                    <li class="gnav__item"><router-link to="/users" class="gnav__link">User</router-link></li>
                </ul>
            </nav>
            <LanguageSwitcher />

            <Button
                type="submit"
                label="Logout"
                :disabled="false"
                @click="handleLogout()"
            />
        </div>
    </header>
    <!-- /HEADER -->
</template>

