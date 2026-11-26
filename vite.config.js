import inertia from '@inertiajs/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        // Resolves pages from resources/js/pages and handles SSR (dev + build) automatically
        inertia(),
        vue({
            template: {
                // Keep absolute URLs like /images/logo.png as plain URLs (served from public/)
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
