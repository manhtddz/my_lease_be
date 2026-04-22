import '@/bootstrap';
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from '@/admin/App.vue'
import router from './app/router'
import config from './config/config'
import piniaPersist from 'pinia-plugin-persistedstate'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/css/index.css'
import '../../css/app.css'
import Vue3Toastify, { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

import { useMainStore } from './stores/main';
import { i18n } from './i18n';


// import '../css/app.css';

const app = createApp(App);

const pinia = createPinia();
pinia.use(piniaPersist);

app.use(pinia).component('Loading', Loading);
app.config.globalProperties.$config = config;
app.use(router)
app.use(i18n)

// Configure vue3-toastify globally - container will be automatically mounted to body
// The plugin automatically creates a container that persists across route changes
// This ensures toast notifications survive navigation
app.use(Vue3Toastify, {
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
    transition: toast.TRANSITIONS.SLIDE,
    hideProgressBar: false,
    newestOnTop: true,
    closeOnClick: true,
    pauseOnHover: true,
    draggable: true,
    rtl: false,
    theme: 'light',
    clearOnUrlChange: false, // Important: prevent toast from being cleared on route change
});

const mainStore = useMainStore();
mainStore.initLocale();

app.mount('#app');
