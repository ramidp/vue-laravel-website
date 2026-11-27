<script setup>
import { computed, ref } from 'vue';
import { assets } from '../../home/data.js';

const props = defineProps({
    services: { type: Array, required: true },
});

const active = ref(0);
const panel = computed(() => props.services[active.value] ?? null);
const nextIndex = computed(() => (props.services.length ? (active.value + 1) % props.services.length : 0));
const nextLabel = computed(() => {
    const tab = props.services[nextIndex.value];
    if (!tab) return '';
    return `${tab.line1} ${tab.line2}`
        .toLowerCase()
        .replace(/\b\w/g, (letter) => letter.toUpperCase());
});

function showNext() {
    active.value = nextIndex.value;
}
</script>

<template>
    <div v-if="panel" class="services-body">
        <div class="service-tabs" role="tablist" aria-label="Services">
            <button
                v-for="(tab, index) in services"
                :key="tab.number"
                class="service-tab"
                :class="{ 'is-active': index === active }"
                type="button"
                role="tab"
                :id="`service-tab-${tab.number}`"
                :aria-selected="index === active"
                aria-controls="service-panel"
                :style="{ '--tab-order': index * 2 }"
                @click="active = index"
            >
                <span>{{ tab.number }}</span>
                <p class="service-tab-title">
                    {{ tab.line1 }}
                    <span>{{ tab.line2 }}</span>
                </p>
                <p class="service-tab-count">{{ tab.count }}</p>
            </button>
        </div>
        <div
            class="service-panel"
            role="tabpanel"
            id="service-panel"
            :aria-labelledby="`service-tab-${panel.number}`"
            :style="{ '--panel-order': active * 2 + 1 }"
        >
            <div class="service-panel-title">
                <span class="watermark">{{ panel.number }}</span>
                <h3>
                    {{ panel.line1 }}
                    <br>
                    <span>{{ panel.line2 }}</span>
                </h3>
            </div>
            <p>{{ panel.text }}</p>
            <div class="service-columns">
                <ul v-for="(column, columnIndex) in panel.columns" :key="columnIndex">
                    <li v-for="(item, itemIndex) in column" :key="`${columnIndex}-${itemIndex}`">
                        <img :src="assets.check" alt="" width="27" height="24">
                        {{ item }}
                    </li>
                </ul>
            </div>
            <div class="service-panel-foot">
                <p>Built to perform. Not just look good.</p>
                <button type="button" class="service-next" @click="showNext">
                    <span>Next: {{ nextLabel }}</span>
                    <span aria-hidden="true">→</span>
                </button>
            </div>
        </div>
    </div>
</template>
