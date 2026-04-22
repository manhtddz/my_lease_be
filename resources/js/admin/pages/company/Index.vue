<template>
    <h1 class="title is-pagetitle">Company</h1>
    <div class="main__container" v-if="!loading">
        <section class="main__section">
            <figure class="image">
                <img :src="settings?.image_url" alt="UNITED Corporation Photo" width="368" height="256" loading="lazy">
            </figure>
            <ul class="datatbl">
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Business Name</h2>
                    <p class="datatbl__block" > {{ settings?.business_name }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Company Name</h2>
                    <p class="datatbl__block">{{ settings?.company_name_en }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Established</h2>
                    <p class="datatbl__block">{{ settings?.establish }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Representative</h2>
                    <p class="datatbl__block">{{ settings?.president_name_en }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Head Office</h2>
                    <p class="datatbl__block">{{ settings?.address_en }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Business Hours</h2>
                    <p class="datatbl__block">{{ settings?.business_hour_en }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Phone</h2>
                    <p class="datatbl__block">
                        {{ settings?.tel }} (Japanese)
                        <br>
                        {{ settings?.tel_en }} (English)
                    </p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Email</h2>
                    <p class="datatbl__block">{{ settings?.email }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Services</h2>
                    <p class="datatbl__block">{{ settings?.service_en }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">License</h2>
                    <p class="datatbl__block">{{ settings?.license_en }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Languages Supported</h2>
                    <p class="datatbl__block">{{ settings?.lang_support }}</p>
                </li>
                <li class="datatbl__item">
                    <h2 class="datatbl__label">Website</h2>
                    <p class="datatbl__block"><a href="https://untd.co.jp/" class="txtlink" target="_blank" rel="noopener noreferrer">{{ settings?.site_url }}</a></p>
                </li>
            </ul>
        </section>
        <div class="embed company__embed">
            <iframe class="embed__map" title="UNITED Corporation Office Map" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4252.765786472566!2d127.74768128228301!3d26.322111380475956!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34e5124559419b67%3A0x2f1ed6e50d80d805!2sUnited%20Corporation!5e0!3m2!1sen!2sjp!4v1751710774811!5m2!1sen!2sjp" width="872" height="340" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { SettingsService } from '@admin/services/settings'

const settings = ref<any>(null);
const loading = ref(true);

onMounted(async () => {
    try {
        settings.value = await SettingsService.get();
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
});
</script>
