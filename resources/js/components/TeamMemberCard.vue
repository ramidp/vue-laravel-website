<script setup>
// Reusable card: receives one team member from the database
defineProps({
    name: { type: String, required: true },
    role: { type: String, required: true },
    photo: { type: String, default: null },
    initials: { type: String, default: '' },
});
</script>

<template>
    <article class="member">
        <img v-if="photo" class="member__photo" :src="photo" :alt="name" loading="lazy">
        <div v-else class="member__avatar">{{ initials }}</div>

        <h3 class="member__name">{{ name }}</h3>
        <p class="member__role">{{ role }}</p>
    </article>
</template>
