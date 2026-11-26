<script setup>
// Reusable card: receives one service from the database
const props = defineProps({
    number: { type: Number, required: true },
    title: { type: String, required: true },
    description: { type: String, required: true },
    link: { type: String, default: null },
});

// 1 -> "01"
const formattedNumber = String(props.number).padStart(2, '0');
</script>

<template>
    <article class="card">
        <div class="card__body">
            <span class="card__number">{{ formattedNumber }}</span>
            <h3 class="card__title">{{ title }}</h3>
            <p class="card__text">{{ description }}</p>

            <a v-if="link" :href="link" class="card__link">Learn more &rarr;</a>
        </div>
    </article>
</template>
