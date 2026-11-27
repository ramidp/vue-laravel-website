<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import LogoMarquee from '../components/home/LogoMarquee.vue';
import WorkMarquee from '../components/home/WorkMarquee.vue';
import ServicesTabs from '../components/home/ServicesTabs.vue';
import TeamMarquee from '../components/home/TeamMarquee.vue';
import TestimonialsSection from '../components/sections/TestimonialsSection.vue';
import { assets, stats } from '../home/data.js';

const props = defineProps({
    testimonials: { type: Array, required: true },
    teamMembers: { type: Array, required: true },
    clientLogos: { type: Array, required: true },
    workRowA: { type: Array, required: true },
    workRowB: { type: Array, required: true },
    services: { type: Array, required: true },
    journey: { type: Array, required: true },
    platforms: { type: Array, required: true },
    emailShots: { type: Array, required: true },
    demoReel: { type: Object, default: null },
});

const page = usePage();
const headerLinks = computed(() => page.props.headerLinks ?? []);
const socialLinks = computed(() => page.props.socialLinks ?? []);
const company = computed(() => page.props.company ?? {
    line1: '',
    line2: '',
    phone: '',
    phoneUrl: '',
    buttonLabel: 'Chat With Us',
    buttonUrl: '/contact',
});

const reelOpen = ref(false);
const reelButton = ref(null);
const reelClose = ref(null);
const reelVideo = ref(null);
const activeReel = ref(null);

function reelForViewport() {
    const reel = props.demoReel;
    if (!reel) return null;
    const mobile = window.matchMedia('(max-width: 767px)').matches;
    return mobile ? (reel.mobile || reel.desktop) : (reel.desktop || reel.mobile);
}

function openReel() {
    const src = reelForViewport();
    if (!src) return;
    activeReel.value = src;
    reelOpen.value = true;
    document.body.style.overflow = 'hidden';
    nextTick(() => {
        reelClose.value?.focus();
        reelVideo.value?.play()?.catch(() => {});
    });
}

function closeReel() {
    reelVideo.value?.pause();
    reelOpen.value = false;
    document.body.style.overflow = '';
    reelButton.value?.focus();
}

function onReelKey(event) {
    if (event.key === 'Escape' && reelOpen.value) closeReel();
}

onMounted(() => window.addEventListener('keydown', onReelKey));
onBeforeUnmount(() => {
    window.removeEventListener('keydown', onReelKey);
    document.body.style.overflow = '';
});
</script>

<template>
    <Head title="Home">
        <meta name="description" content="We build performance ads, landing pages and emails that convert.">
    </Head>

    <AppLayout bare>
        <div class="home-page">
            <div class="page">
                <header class="site-header">
                    <div class="header-bar">
                        <nav v-if="headerLinks.length" class="header-nav" aria-label="Sections">
                            <template v-for="item in headerLinks" :key="item.id">
                                <a v-if="item.url" :href="item.url">{{ item.label }}</a>
                                <span v-else>{{ item.label }}</span>
                            </template>
                        </nav>
                        <img class="site-logo" :src="assets.logo" alt="MADHUB" width="124" height="102">
                        <a class="nav-menu" :href="company.buttonUrl" :aria-label="company.buttonLabel">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                        <a class="btn" :href="company.buttonUrl">
                            <span>{{ company.buttonLabel }}</span>
                            <img :src="assets.arrow" alt="" width="15" height="15">
                        </a>
                    </div>
                </header>

                <section class="hero">
                    <div class="hero-media" aria-hidden="true">
                        <img :src="assets.hero" alt="">
                    </div>
                    <div class="hero-copy">
                        <p class="eyebrow-hero"><span>WE</span><span>ENCOURAGE</span></p>
                        <h1 class="crazy-title">
                            <img class="crazy-line" :src="assets.crazyLine" alt="" width="438" height="59">
                            <span>CRAZY</span>
                        </h1>
                        <p>
                            <strong>Because average is crowded. </strong>
                            From Creative Performance Ads that spark action, to Persona-Driven Landing Pages and Emails that capture and keep your audience.
                            <br>
                            <strong>We build INSANE customer journeys that convert.</strong>
                        </p>
                        <button ref="reelButton" type="button" class="btn btn-pill" @click="openReel">
                            <span>Watch Demo Reel</span>
                            <img :src="assets.arrowPill" alt="" width="38" height="38">
                        </button>
                    </div>
                    <div class="logo-rows">
                        <LogoMarquee :logos="clientLogos" direction="left" />
                    </div>
                </section>

                <section class="wrap brands">
                    <div class="brands-intro">
                        <h2>
                            FOR <span>BRANDS</span> DONE GUESSING
                        </h2>
                        <p>
                            We’re the Creative Performance Partner
                            <br>
                            brands call to scale with intention.
                        </p>
                    </div>
                    <div class="stat-grid">
                        <article v-for="stat in stats" :key="stat.value" class="stat-card">
                            <p class="stat-value" :style="{ fontSize: stat.suffixSize + 'px' }">
                                <img class="stat-arrow" :src="assets.arrowUp" alt="" width="40" height="50">
                                {{ stat.value }}
                                <span>{{ stat.suffix }}</span>
                            </p>
                            <p class="stat-text">{{ stat.text }}</p>
                            <img :src="stat.logo" :alt="stat.logoAlt" :width="stat.logoWidth" :height="stat.logoHeight">
                        </article>
                    </div>
                    <a class="btn" href="#work">
                        <span>Read cases studies</span>
                        <img :src="assets.arrow" alt="" width="15" height="15">
                    </a>
                </section>

                <section class="quote-block">
                    <img class="quote-scribble" :src="assets.quoteScribble" alt="" width="55" height="41">
                    <blockquote>
                        <p>Our main Creative KPI is making other brands rage-screenshot your ads”.</p>
                        <footer>
                            <strong>Yves Caradec, </strong>
                            <span>Founder & CCO</span>
                        </footer>
                    </blockquote>
                </section>

                <section class="work" id="work" aria-label="Selected work">
                    <WorkMarquee v-if="workRowA.length" :items="workRowA" direction="left" />
                    <WorkMarquee v-if="workRowB.length" class="is-extra" :items="workRowB" direction="right" />
                </section>

                <section class="services" aria-labelledby="services-title">
                    <div class="services-heading">
                        <p>SERVICES</p>
                        <h2 id="services-title">
                            WHAT WE <span>DO</span>
                        </h2>
                    </div>
                    <ServicesTabs :services="services" />
                </section>

                <section class="journey">
                    <div class="journey-intro">
                        <h2>
                            THE MADHUB <span>CUSTOMER JOURNEY</span>
                        </h2>
                        <p>
                            A connected path for every persona: the right Ad Angle, the right Landing Page, the right Email Flow. Each tested and measured separately, so we know what to scale.
                        </p>
                    </div>
                    <div class="journey-grid">
                        <article v-for="(step, index) in journey" :key="step.number">
                            <div class="step-head">
                                <span class="step-badge">
                                    <img :src="assets.stepRing" alt="" width="61" height="71">
                                    <img :src="assets.stepFill" alt="" width="53" height="53">
                                    <strong>{{ step.number }}</strong>
                                </span>
                                <h3>{{ step.label }}</h3>
                                <img
                                    v-if="index < journey.length - 1"
                                    class="step-arrow"
                                    :src="assets.stepArrow"
                                    alt=""
                                    width="177"
                                    height="15"
                                >
                            </div>
                            <div class="journey-visual">
                                <img :src="step.image" alt="">
                            </div>
                            <h4>{{ step.title }}</h4>
                            <p>{{ step.text }}</p>
                        </article>
                    </div>
                </section>

                <section class="founders">
                    <div class="founders-stage">
                        <img class="founders-photo" :src="assets.founders" alt="Yves Caradec and Steve Kostrey">
                        <h2>
                            <span>OUR </span>FOUNDERS
                        </h2>
                        <h3 class="founder-name founder-name-yves">
                            <strong>Yves Caradec</strong>
                            Chief Creative Officer
                        </h3>
                        <h3 class="founder-name founder-name-steve">
                            <strong>Steve Kostrey</strong>
                            Chief Technology Officer
                        </h3>
                        <aside>
                            <p>
                                <strong>A creative performance agency and a dev shop walk into a bar. </strong>
                                <strong class="boom">BOOM!</strong>
                            </p>
                            <p>
                                With over 40 years of combined experience, Yves Caradec and Steve Kostrey joined forces to build a powerhouse marketing operation. Now, pre-click meets post-click to deliver crazy creatives, scalable performance, sticky retention, and insane brand growth.
                            </p>
                        </aside>
                    </div>
                </section>

                <TestimonialsSection :testimonials="testimonials" />

                <section class="execute wrap">
                    <h2>WHERE WE EXECUTE:</h2>
                    <p>Our team has re-engineered growth across every major paid and social channel — proven across real campaigns, real budgets, and real clients.</p>
                    <div class="platform-grid">
                        <div
                            v-for="group in platforms"
                            :key="group.row"
                            class="platform-row"
                            :class="{ 'is-spread': group.row === 2 }"
                        >
                            <div v-for="logo in group.logos" :key="logo.src">
                                <img :src="logo.src" :alt="logo.alt">
                            </div>
                        </div>
                    </div>
                </section>

                <section class="emails">
                    <div class="emails-copy">
                        <h2>
                            EMAILS THAT GRAB
                            <br>
                            <span class="attention">
                                ATTENTION
                                <img :src="assets.attentionCross" alt="" width="401" height="14">
                            </span>
                            RETENTION
                        </h2>
                        <p>Lifecycle flows, retention strategy, and performance creative designed to turn first-time buyers into repeat customers.</p>
                    </div>
                    <div class="email-row">
                        <div
                            v-for="shot in emailShots"
                            :key="shot.src"
                            class="email-shot"
                            :class="{ 'is-wide': shot.wide, 'is-dim': shot.dim }"
                        >
                            <img :src="shot.src" alt="Email creative">
                        </div>
                    </div>
                </section>

                <section class="team" aria-label="Team">
                    <TeamMarquee :members="teamMembers" />
                </section>

                <section class="cta-band" id="lets-get-started">
                    <h2 class="cta-desktop">LET’S GET STARTED</h2>
                    <h2 class="cta-mobile">LET’S HAVE SOME TEA</h2>
                    <p>
                        Want to be part of the <strong>MAD</strong>ness?
                        <br>
                        We’re excited to hear from you.
                    </p>
                    <a class="btn cta-desktop" href="/contact">
                        <span>Become a client</span>
                        <img :src="assets.arrow" alt="" width="15" height="15">
                    </a>
                    <a class="btn cta-mobile" href="/contact">
                        <span>Chat With Us</span>
                        <img :src="assets.arrow" alt="" width="15" height="15">
                    </a>
                </section>

                <footer class="site-footer" id="footer">
                    <img class="footer-line" :src="assets.divider" alt="" width="1218" height="1">
                    <div class="footer-row">
                        <div class="socials">
                            <a
                                v-for="link in socialLinks"
                                :key="link.id"
                                :href="link.url"
                                :aria-label="link.name"
                                :target="link.external ? '_blank' : undefined"
                                :rel="link.external ? 'noopener noreferrer' : undefined"
                            >
                                <img :src="link.icon" alt="" width="31" height="31">
                            </a>
                        </div>
                        <img class="footer-logo" :src="assets.logo" alt="MADHUB" width="90" height="74">
                        <address v-if="company.line1 || company.phone">
                            {{ company.line1 }}
                            <br v-if="company.line2">
                            <template v-if="company.line2">{{ company.line2 }}</template>
                            <br>
                            <br>
                            <a v-if="company.phone" :href="company.phoneUrl || undefined">{{ company.phone }}</a>
                        </address>
                    </div>
                </footer>
            </div>
        </div>

        <Teleport to="body">
            <div
                v-if="reelOpen"
                class="reel-modal"
                role="dialog"
                aria-modal="true"
                aria-label="Demo reel"
                @click.self="closeReel"
            >
                <div class="reel-modal-panel">
                    <button ref="reelClose" type="button" class="reel-modal-close" aria-label="Close" @click="closeReel">
                        ×
                    </button>
                    <video
                        ref="reelVideo"
                        :key="activeReel"
                        :src="activeReel"
                        controls
                        playsinline
                        autoplay
                    ></video>
                </div>
            </div>
        </Teleport>
    </AppLayout>
</template>
