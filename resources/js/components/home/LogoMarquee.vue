<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

const GAP = 60;
const SPEED = 40;

defineProps({
    logos: { type: Array, required: true },
    direction: { type: String, required: true },
});

const copies = ref(2);
const shift = ref(0);
let setEl = null;

function bindSet(el) {
    if (el) setEl = el;
}

function measure() {
    if (!setEl) return;
    const width = setEl.getBoundingClientRect().width;
    if (width < 10) return;
    const setWidth = width + GAP;
    const viewport = setEl.parentElement?.parentElement?.clientWidth || window.innerWidth;
    copies.value = Math.max(2, Math.ceil(viewport / setWidth) + 1);
    shift.value = setWidth;
}

let images = [];

onMounted(() => {
    measure();
    images = setEl ? [...setEl.querySelectorAll('img')] : [];
    images.forEach((img) => {
        if (!img.complete) img.addEventListener('load', measure);
    });
    window.addEventListener('resize', measure);
});

onBeforeUnmount(() => {
    images.forEach((img) => img.removeEventListener('load', measure));
    window.removeEventListener('resize', measure);
});
</script>

<template>
    <div class="logo-marquee">
        <div
            class="logo-marquee-track"
            :class="`is-${direction}`"
            :style="{
                '--shift': shift + 'px',
                animationDuration: shift ? (shift / SPEED) + 's' : undefined,
            }"
        >
            <div
                v-for="copy in copies"
                :key="copy"
                class="logo-marquee-set"
                :ref="copy === 1 ? bindSet : undefined"
                :aria-hidden="copy > 1 ? 'true' : undefined"
            >
                <img
                    v-for="(logo, index) in logos"
                    :key="`${copy}-${logo.src}-${index}`"
                    :src="logo.src"
                    :alt="logo.alt || 'Client logo'"
                >
            </div>
        </div>
    </div>
</template>
