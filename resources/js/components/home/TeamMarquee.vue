<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

const SPEED = 40;

defineProps({
    members: { type: Array, required: true },
});

const viewportRef = ref(null);
const trackRef = ref(null);
let setEl = null;

function bindSet(el) {
    if (el) setEl = el;
}

onMounted(() => {
    const viewport = viewportRef.value;
    const track = trackRef.value;
    const set = setEl;
    if (!viewport || !track || !set) return;

    let setWidth = 0;
    let offset = 0;
    let dragging = false;
    let last = performance.now();
    let frame = 0;
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)');

    function wrap(value) {
        if (setWidth <= 0) return value;
        const mod = ((value % setWidth) + setWidth) % setWidth;
        return mod - setWidth;
    }

    function paint() {
        track.style.transform = `translate3d(${offset}px, 0, 0)`;
    }

    function measure() {
        const gap = parseFloat(getComputedStyle(track).gap) || 0;
        const width = set.getBoundingClientRect().width + gap;
        if (width < 10) return;
        const ratio = setWidth > 0 ? offset / setWidth : -1;
        setWidth = width;
        offset = wrap(ratio * setWidth);
        paint();
    }

    function tick(now) {
        const dt = Math.min(now - last, 50) / 1000;
        last = now;
        if (!dragging && !reduce.matches && setWidth > 0) {
            offset = wrap(offset - SPEED * dt);
            paint();
        }
        frame = requestAnimationFrame(tick);
    }

    function down(event) {
        if (event.button !== 0) return;
        const startX = event.clientX;
        const startY = event.clientY;
        const startOffset = offset;
        let active = false;

        function move(ev) {
            const dx = ev.clientX - startX;
            const dy = ev.clientY - startY;
            if (!active) {
                if (Math.abs(dx) < 6 && Math.abs(dy) < 6) return;
                if (Math.abs(dy) > Math.abs(dx)) {
                    window.removeEventListener('pointermove', move);
                    window.removeEventListener('pointerup', up);
                    return;
                }
                active = true;
                dragging = true;
                viewport.classList.add('is-dragging');
            }
            offset = wrap(startOffset + dx);
            paint();
        }

        function up() {
            active = false;
            dragging = false;
            viewport.classList.remove('is-dragging');
            window.removeEventListener('pointermove', move);
            window.removeEventListener('pointerup', up);
        }

        window.addEventListener('pointermove', move);
        window.addEventListener('pointerup', up);
    }

    measure();
    const images = [...set.querySelectorAll('img')];
    images.forEach((img) => {
        if (!img.complete) img.addEventListener('load', measure);
    });
    window.addEventListener('resize', measure);
    viewport.addEventListener('pointerdown', down);
    frame = requestAnimationFrame(tick);

    cleanup = () => {
        cancelAnimationFrame(frame);
        images.forEach((img) => img.removeEventListener('load', measure));
        window.removeEventListener('resize', measure);
        viewport.removeEventListener('pointerdown', down);
    };
});

let cleanup = () => {};

onBeforeUnmount(() => cleanup());
</script>

<template>
    <div ref="viewportRef" class="team-marquee">
        <div ref="trackRef" class="team-marquee-track">
            <div
                v-for="copy in 3"
                :key="copy"
                class="team-row"
                :ref="copy === 1 ? bindSet : undefined"
                :aria-hidden="copy > 1 ? 'true' : undefined"
            >
                <img
                    v-for="person in members"
                    :key="`${copy}-${person.id}`"
                    :src="person.photo"
                    :alt="copy === 1 ? (person.name || 'MADHUB team member') : ''"
                    width="200"
                    height="200"
                    draggable="false"
                >
            </div>
        </div>
    </div>
</template>
