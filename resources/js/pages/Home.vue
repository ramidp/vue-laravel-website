<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import HeroSection from '../components/sections/HeroSection.vue';
import ServicesSection from '../components/sections/ServicesSection.vue';
import WorkCarousel from '../components/sections/WorkCarousel.vue';
import TeamSection from '../components/sections/TeamSection.vue';
import ContactSection from '../components/sections/ContactSection.vue';
import NewsletterSection from '../components/sections/NewsletterSection.vue';

// Props sent by HomeController@index with Inertia::render('Home', [...])
defineProps({
    services: { type: Array, required: true },
    teamMembers: { type: Array, required: true },
});
</script>

<template>
    <Head title="Home">
        <meta name="description" content="We build performance ads, landing pages and emails that convert.">
    </Head>

    <AppLayout>
        <HeroSection />
        <ServicesSection :services="services" />
        <WorkCarousel />
        <TeamSection :members="teamMembers" />
        <ContactSection />
        <NewsletterSection />
    </AppLayout>
</template>
