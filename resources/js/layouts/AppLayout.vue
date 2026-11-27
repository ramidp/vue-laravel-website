<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import SiteHeader from '../components/SiteHeader.vue';
import SiteFooter from '../components/SiteFooter.vue';

// Shared props from HandleInertiaRequests (available on every page)
const page = usePage();
const status = computed(() => page.props.flash.status);

defineProps({
    // Homepage draws its own header and footer from the design.
    bare: { type: Boolean, default: false },
});
</script>

<template>
    <SiteHeader v-if="!bare" />

    <!-- One-time flash message, e.g. ->with('status', '...') in a controller -->
    <div v-if="status" class="flash">
        <div class="container">{{ status }}</div>
    </div>

    <main>
        <!-- Each page injects its content here (like @yield('content') in Blade) -->
        <slot />
    </main>

    <SiteFooter v-if="!bare" />
</template>
