import { defineStore } from 'pinia';
import { ref } from 'vue';
import { i18n } from '../i18n';

export const useMainStore = defineStore('main', () => {
    const pageTitle = ref('');
    const pageDescription = ref('');
    const isFilterOpen = ref(false);
    const locale = ref<"ja" | "en">(i18n.global.locale.value as "ja" | "en")

    function setFilterOpen(value: boolean) {
        isFilterOpen.value = value;
    }

    function toggleFilter() {
        isFilterOpen.value = !isFilterOpen.value;
    }

    function setPageTitle(title: string) {
        pageTitle.value = title;
        document.title = title;
    }

    function setPageDescription(desc: string) {
        pageDescription.value = desc;
        const meta = document.querySelector('meta[name="description"]');
        if (meta) meta.setAttribute('content', desc);
    }

    function setLocale(newLocale: "ja" | "en") {
        locale.value = newLocale
        i18n.global.locale.value = newLocale
        localStorage.setItem("locale", newLocale)
    }

    function initLocale() {
        const saved = localStorage.getItem("locale") as "ja" | "en";
        if (saved) {
            setLocale(saved);
        }
    }

    return {
        isFilterOpen,
        toggleFilter,
        setFilterOpen,
        pageTitle,
        pageDescription,
        setPageTitle,
        setPageDescription,
        locale,
        initLocale,
        setLocale
    };
});
