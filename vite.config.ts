import { defineConfig, loadEnv } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    return {
        plugins: [
            laravel({
                input: {
                    client: 'resources/js/app.js',
                    admin: 'resources/js/admin/main.ts',
                    style: 'resources/css/app.css',
                },
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        resolve: {
            alias: {
                '@admin': '/resources/js/admin',
                'vue': 'vue/dist/vue.esm-bundler.js',
            },
        },
        server: {
            host: 'localhost',
            port: 5173,
        },
        define: {
            __APP_API_BASE_URL__: JSON.stringify(env.API_BASE_URL || ''),
        },
    };
});
