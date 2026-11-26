<script setup>
import ServiceCard from '../ServiceCard.vue';

// services comes from HomeController (services table)
defineProps({
    services: { type: Array, required: true },
});
</script>

<template>
    <section id="services" class="section">
        <div class="container">
            <div class="section__head">
                <h2 class="section__title">What <span>we do</span></h2>
                <p class="section__subtitle">Everything you need to build customer journeys that convert.</p>
            </div>

            <div class="cards-grid">
                <ServiceCard
                    v-for="(service, index) in services"
                    :key="service.id"
                    :number="index + 1"
                    :title="service.title"
                    :description="service.description"
                    :link="service.link"
                />

                <p v-if="!services.length" class="empty-state">No services yet.</p>
            </div>
        </div>
    </section>
</template>
