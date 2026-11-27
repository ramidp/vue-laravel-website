<script setup>
/**
 * "Madly Ever After" testimonial row.
 * Cards match the Figma frame. The track follows the cursor while dragging
 * and keeps a short glide after release. Browser-only code runs in onMounted.
 */
import { onBeforeUnmount, onMounted, ref } from 'vue';

// Rows come from HomeController (testimonials table)
defineProps({
    testimonials: { type: Array, required: true },
});

const STIFFNESS = 22;
const FRICTION = 3.4;
const EDGE = 0.35;
const DRAG_START = 6;

const root = ref(null);
const track = ref(null);
const isDragging = ref(false);

let x = 0;
let target = 0;
let velocity = 0;
let frameId = 0;
let previousFrame = 0;
let pointer = null;
let reduceMotion = false;

function limits() {
    if (!root.value || !track.value) return { min: 0, max: 0 };
    return { min: Math.min(0, root.value.clientWidth - track.value.scrollWidth), max: 0 };
}

function moveBy(delta) {
    const { min, max } = limits();
    const next = target + delta;
    if (next > max || next < min) target += delta * EDGE;
    else target += delta;
}

function tick(now) {
    const dt = Math.min((now - previousFrame) / 1000, 0.032);
    previousFrame = now;

    if (!isDragging.value && !reduceMotion) {
        const { min, max } = limits();
        if (target > max || target < min) {
            const edge = target > max ? max : min;
            target += (edge - target) * (1 - Math.exp(-12 * dt));
            velocity = 0;
        } else {
            target += velocity * dt;
            velocity *= Math.exp(-FRICTION * dt);
            if (Math.abs(velocity) < 12) velocity = 0;
        }
    }

    const follow = reduceMotion ? 1 : 1 - Math.exp(-STIFFNESS * dt);
    x += (target - x) * follow;

    if (track.value) track.value.style.transform = `translate3d(${x}px, 0, 0)`;
    frameId = requestAnimationFrame(tick);
}

function onPointerDown(event) {
    if (event.button !== undefined && event.button !== 0) return;
    pointer = {
        id: event.pointerId,
        x: event.clientX,
        y: event.clientY,
    };
    velocity = 0;
    previousFrame = performance.now();
}

function onPointerMove(event) {
    if (!pointer || event.pointerId !== pointer.id) return;

    const dx = event.clientX - pointer.x;
    const dy = event.clientY - pointer.y;

    if (!isDragging.value) {
        if (Math.abs(dx) < DRAG_START && Math.abs(dy) < DRAG_START) return;
        if (Math.abs(dy) > Math.abs(dx)) {
            pointer = null;
            return;
        }
        isDragging.value = true;
        root.value.setPointerCapture(event.pointerId);
        pointer.x = event.clientX;
        pointer.last = event.clientX;
        pointer.time = performance.now();
        return;
    }

    const now = performance.now();
    const step = event.clientX - pointer.last;
    const elapsed = Math.max((now - pointer.time) / 1000, 0.001);
    velocity = step / elapsed;
    moveBy(step);
    pointer.last = event.clientX;
    pointer.time = now;
}

function onPointerUp(event) {
    if (!pointer || event.pointerId !== pointer.id) return;

    if (isDragging.value && root.value?.hasPointerCapture(event.pointerId)) {
        root.value.releasePointerCapture(event.pointerId);
    }

    if (reduceMotion || performance.now() - (pointer.time || 0) > 80) velocity = 0;
    velocity = Math.max(-2800, Math.min(2800, velocity));

    isDragging.value = false;
    pointer = null;
}

function onWheel(event) {
    if (Math.abs(event.deltaX) <= Math.abs(event.deltaY)) return;
    event.preventDefault();
    velocity = 0;
    moveBy(-event.deltaX);
}

function onKeydown(event) {
    if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
    event.preventDefault();
    velocity = 0;
    moveBy(event.key === 'ArrowLeft' ? 374 : -374);
}

function onResize() {
    const { min, max } = limits();
    target = Math.min(max, Math.max(min, target));
}

onMounted(() => {
    reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    previousFrame = performance.now();
    frameId = requestAnimationFrame(tick);
    window.addEventListener('resize', onResize);
    root.value.addEventListener('wheel', onWheel, { passive: false });
});

onBeforeUnmount(() => {
    cancelAnimationFrame(frameId);
    window.removeEventListener('resize', onResize);
    root.value?.removeEventListener('wheel', onWheel);
});
</script>

<template>
    <section id="testimonials" class="testimonials" aria-labelledby="testimonials-title">
        <div class="testimonials__band">
            <h2 id="testimonials-title" class="testimonials__title">Madly Ever After</h2>

            <div
                ref="root"
                class="testimonials__scroller"
                :class="{ 'is-dragging': isDragging }"
                role="region"
                aria-label="Client testimonials"
                tabindex="0"
                @pointerdown="onPointerDown"
                @pointermove="onPointerMove"
                @pointerup="onPointerUp"
                @pointercancel="onPointerUp"
                @keydown="onKeydown"
            >
                <div ref="track" class="testimonials__track">
                    <article v-for="item in testimonials" :key="item.id" class="quote-card">
                        <header class="quote-card__person">
                            <img
                                class="quote-card__photo"
                                :src="item.photo"
                                :alt="item.name"
                                :style="{ objectPosition: item.photoPosition || 'center' }"
                                draggable="false"
                                loading="lazy"
                            >
                            <div class="quote-card__meta">
                                <img class="quote-card__stars" src="/images/f6ee8.svg" alt="5 stars" width="103" height="17">
                                <p class="quote-card__name">{{ item.name }}</p>
                                <p class="quote-card__role">{{ item.role }}</p>
                            </div>
                        </header>

                        <img class="quote-card__mark" src="/images/f0760.svg" alt="" width="19" height="15">
                        <p class="quote-card__text">{{ item.quote }}</p>

                        <div
                            v-if="item.logo.crop"
                            class="quote-card__logo quote-card__logo--crop"
                            :style="{
                                width: item.logo.width + 'px',
                                height: item.logo.height + 'px',
                                mixBlendMode: item.logo.blend || 'normal',
                            }"
                        >
                            <img
                                :src="item.logo.src"
                                :alt="item.logo.alt"
                                :style="item.logo.crop"
                                draggable="false"
                            >
                        </div>
                        <img
                            v-else
                            class="quote-card__logo"
                            :src="item.logo.src"
                            :alt="item.logo.alt"
                            :style="{ width: item.logo.width + 'px', height: item.logo.height + 'px' }"
                            draggable="false"
                        >
                    </article>
                </div>
            </div>
        </div>
    </section>
</template>
