import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vuetify from "vite-plugin-vuetify";

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vuetify({autoImport: true}),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    rollupOptions: {
        external: ['vue', 'vuetify'],
        output: {
            globals: {
                vue: 'Vue',
                vuetify: 'Vuetify',
            },
        },
    },
    ssr: {
        noExternal: ['vuetify', 'vue', 'lodash']
    }
});
