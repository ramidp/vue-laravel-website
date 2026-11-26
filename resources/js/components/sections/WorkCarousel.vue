<script setup>
/**
 * Infinite draggable carousel.
 *
 * - The images are rendered twice. The track moves left with requestAnimationFrame and,
 *   after moving the width of one full set, it jumps back. Both sets are identical,
 *   so the jump is invisible: that is the infinite loop.
 * - Pointer events (mouse + touch + pen) let the user drag. On release, the drag
 *   velocity becomes inertia that decays before auto-scroll resumes.
 * - All browser-only code runs in onMounted, so it is safe with SSR.
 */
import { onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    // Auto-scroll speed in px per second
    speed: { type: Number, default: 45 },
});

// Static images in public/images (image1.png ... image5.png)
const images = [1, 2, 3, 4, 5].map((n) => `/images/image${n}.png`);

const MAX_VELOCITY = 3000;   // px/s cap for the throw after a drag
const FRICTION = 0.04;       // Fraction of velocity left after 1 second of inertia
const DRAG_THRESHOLD = 5;    // px moved before a press counts as a drag

const root = ref(null);
const track = ref(null);
const isDragging = ref(false);

let x = 0;
let setWidth = 0;
let velocity = 0;
let startX = 0;
let lastX = 0;
let lastTime = 0;
let previousFrame = 0;
let frameId = null;
let autoSpeed = 0;

// Half of the track = one set (includes the trailing gap)
function measure() {
    if (track.value) setWidth = track.value.scrollWidth / 2;
}

// Keep x inside (-setWidth, 0] so the loop never ends
function wrap() {
    if (setWidth <= 0) return;
    x = ((x % setWidth) - setWidth) % setWidth;
}

function tick(now) {
    // Seconds since last frame (capped so a background tab doesn't cause a big jump)
    const dt = Math.min((now - previousFrame) / 1000, 0.05);
    previousFrame = now;

    if (!isDragging.value) {
        if (Math.abs(velocity) > 10) {
            // Inertia after a throw
            x += velocity * dt;
            velocity *= Math.pow(FRICTION, dt);
        } else {
            // Normal auto-scroll
            velocity = 0;
            x -= autoSpeed * dt;
        }
    }

    wrap();
    track.value.style.transform = `translate3d(${x}px, 0, 0)`;
    frameId = requestAnimationFrame(tick);
}

function onPointerDown(event) {
    if (event.button !== undefined && event.button !== 0) return;

    isDragging.value = true;
    velocity = 0;
    startX = lastX = event.clientX;
    lastTime = performance.now();

    root.value.setPointerCapture(event.pointerId);
}

function onPointerMove(event) {
    if (!isDragging.value) return;

    const now = performance.now();
    const deltaX = event.clientX - lastX;
    const deltaTime = Math.max((now - lastTime) / 1000, 0.001);

    x += deltaX;
    velocity = deltaX / deltaTime;

    lastX = event.clientX;
    lastTime = now;
}

function onPointerUp(event) {
    if (!isDragging.value) return;

    isDragging.value = false;

    if (root.value.hasPointerCapture(event.pointerId)) {
        root.value.releasePointerCapture(event.pointerId);
    }

    // A simple click, or a drag that stopped before release, should not throw the carousel
    if (Math.abs(event.clientX - startX) < DRAG_THRESHOLD || performance.now() - lastTime > 100) {
        velocity = 0;
    }

    velocity = Math.max(-MAX_VELOCITY, Math.min(MAX_VELOCITY, velocity));
}

onMounted(() => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    autoSpeed = reduceMotion ? 0 : props.speed;

    measure();
    window.addEventListener('resize', measure);
    track.value.querySelectorAll('img').forEach((img) => {
        if (!img.complete) img.addEventListener('load', measure, { once: true });
    });

    previousFrame = performance.now();
    frameId = requestAnimationFrame(tick);
});

onBeforeUnmount(() => {
    cancelAnimationFrame(frameId);
    window.removeEventListener('resize', measure);
});
</script>

<template>
    <section id="work" class="section work">
        <div class="container">
            <div class="section__head">
                <h2 class="section__title">Our <span>work</span></h2>
                <p class="section__subtitle">A few pieces we are proud of.</p>
            </div>
        </div>

        <div
            ref="root"
            class="carousel"
            :class="{ 'is-dragging': isDragging }"
            @pointerdown="onPointerDown"
            @pointermove="onPointerMove"
            @pointerup="onPointerUp"
            @pointercancel="onPointerUp"
        >
            <div ref="track" class="carousel__track">
                <!-- The set is rendered twice so the loop can wrap around seamlessly -->
                <template v-for="copy in 2" :key="copy">
                    <figure
                        v-for="(image, index) in images"
                        :key="`${copy}-${index}`"
                        class="carousel__item"
                        :aria-hidden="copy === 2 ? 'true' : null"
                    >
                        <img
                            :src="image"
                            :alt="copy === 1 ? `Project ${index + 1}` : ''"
                            draggable="false"
                            :loading="copy === 1 ? 'eager' : 'lazy'"
                        >
                    </figure>
                </template>
            </div>
        </div>
    </section>
</template>
