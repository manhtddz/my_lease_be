import axios from 'axios';
window.axios = axios;

window.axios.defaults.baseURL = __APP_API_BASE_URL__;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
