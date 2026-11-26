import { createInertiaApp } from '@inertiajs/vue3';

// The @inertiajs/vite plugin generates the page resolver (resources/js/pages)
// and reuses this same file as the SSR entry point.
createInertiaApp({
    // Browser tab title: "Login | MADHUB"
    title: (title) => (title ? `${title} | MADHUB` : 'MADHUB'),

    // Top loading bar during page visits
    progress: {
        color: '#ff4f41',
    },
});
