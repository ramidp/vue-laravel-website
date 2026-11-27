<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const groups = [
    {
        title: 'RETENTION',
        items: [
            'Email Marketing / SMS',
            'Content Marketing',
            'Organic Social',
            'CRM Integration',
            'Loyalty & Rewards',
            'Data Modelling',
        ],
    },
    {
        title: 'PERFORMANCE',
        items: [
            'Meta Ads',
            'Google Search',
            'YouTube Ads',
            'TikTok Ads',
            'Amazon Ads',
            'LinkedIn Ads',
            'Pinterest Ads',
            'Reddit Ads',
            'Broadcast Media',
            'CTV',
        ],
    },
    {
        title: 'CREATIVE',
        items: [
            'Creative Ads',
            'UGC / PGC',
            'AI Creative',
            '3D Modelling',
            'Video Production',
            'Photography',
            'Branding',
            'Design / Packaging',
        ],
    },
    {
        title: 'CONVERSION',
        accent: 'LED',
        items: [
            'Shopify Management',
            'Website Development',
            'Conversion Rate Optimization',
            'Amazon Management',
            'SEO / AEO / GEO',
        ],
    },
];

const budgets = [
    '$5,000 to $10,000',
    '$10,000 to $30,000',
    '$30,000 to $50,000',
    '$50,000 to $100,000',
    'I’d rather not say',
];

const countries = [
    { code: 'CA', name: 'Canada' },
    { code: 'US', name: 'United States' },
    { code: 'GB', name: 'United Kingdom' },
    { code: 'AU', name: 'Australia' },
    { code: 'MX', name: 'Mexico' },
];

const page = usePage();
const headerLinks = computed(() => page.props.headerLinks ?? []);
const socialLinks = computed(() => page.props.socialLinks ?? []);
const company = computed(() => page.props.company ?? {
    line1: '',
    line2: '',
    phone: '',
    phoneUrl: '',
});

const step = ref(1);
const tried = ref(false);
const countryOpen = ref(false);
const country = ref('CA');

const form = ref({
    company: '',
    name: '',
    email: '',
    phone: '',
    website: '',
    services: [],
    budget: '',
    project: '',
});

const emailOk = computed(() => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email.trim()));

const stepOneInvalid = computed(() => ({
    company: form.value.company.trim() === '',
    name: form.value.name.trim() === '',
    email: !emailOk.value,
}));

function hasService(item) {
    return form.value.services.includes(item);
}

function toggleService(item) {
    const list = form.value.services;
    form.value.services = list.includes(item)
        ? list.filter((name) => name !== item)
        : [...list, item];
}

function next() {
    if (step.value === 1) {
        tried.value = true;
        if (stepOneInvalid.value.company || stepOneInvalid.value.name || stepOneInvalid.value.email) return;
    }
    if (step.value < 4) step.value += 1;
    countryOpen.value = false;
}

function prev() {
    if (step.value > 1 && step.value < 5) step.value -= 1;
    countryOpen.value = false;
}

function submit() {
    step.value = 5;
}
</script>

<template>
    <Head title="Contact">
        <meta name="description" content="Tell MADHUB about your project. A short questionnaire so the first conversation counts.">
        <link rel="stylesheet" href="/css/contact.css">
    </Head>

    <AppLayout bare>
        <div class="contact-page">
            <header class="quiz-header">
                <div class="quiz-header-bar">
                    <nav v-if="headerLinks.length" class="quiz-nav-links" aria-label="Sections">
                        <template v-for="item in headerLinks" :key="item.id">
                            <a v-if="item.url" :href="item.url">{{ item.label }}</a>
                            <span v-else>{{ item.label }}</span>
                        </template>
                    </nav>
                    <Link href="/" class="quiz-logo">
                        <img src="/images/8eeb8.png" alt="MADHUB" width="124" height="102">
                    </Link>
                </div>
            </header>

            <div class="quiz-hero" aria-hidden="true">
                <img src="/images/78c1a.png" alt="">
            </div>

            <main class="quiz">
                <div v-if="step < 5" class="quiz-inner">
                    <div class="quiz-heading">
                        <span class="quiz-badge">{{ step }}</span>
                        <div>
                            <h1 v-if="step === 1">Thanks for your interest in MADHUB!</h1>
                            <h1 v-else-if="step === 2">What services would your project require?</h1>
                            <h1 v-else-if="step === 3">My budget is:</h1>
                            <h1 v-else>Tell us more about your project</h1>
                            <p v-if="step === 1" class="quiz-intro">
                                We’re excited to learn more about what you’re building, where you want to go, and how we can help stir things up. Please share your information and complete our quick questionnaire below so we can make our first conversation count.
                            </p>
                        </div>
                    </div>

                    <form class="quiz-form" @submit.prevent="step === 4 ? submit() : next()">
                        <div v-if="step === 1" class="quiz-fields">
                            <label class="field" :class="{ 'is-invalid': tried && stepOneInvalid.company }">
                                <span>Company</span>
                                <input v-model="form.company" type="text" name="company" autocomplete="organization" placeholder="Company Name" required>
                            </label>
                            <label class="field" :class="{ 'is-invalid': tried && stepOneInvalid.name }">
                                <span>Name</span>
                                <input v-model="form.name" type="text" name="name" autocomplete="name" placeholder="Yves Caradec" required>
                            </label>
                            <label class="field" :class="{ 'is-invalid': tried && stepOneInvalid.email }">
                                <span>Email</span>
                                <input v-model="form.email" type="email" name="email" autocomplete="email" placeholder="myemail@gmail.com" required>
                            </label>
                            <div class="field">
                                <span id="phone-label">Phone</span>
                                <div class="phone-row">
                                    <div class="country">
                                        <button type="button" class="country-btn" aria-haspopup="listbox" :aria-expanded="countryOpen" aria-labelledby="phone-label" @click="countryOpen = !countryOpen">
                                            <img v-if="country === 'CA'" src="/images/5debf.svg" alt="" width="18" height="17">
                                            <span v-else class="country-code">{{ country }}</span>
                                            <img class="chevron" :class="{ 'is-open': countryOpen }" src="/images/05566.svg" alt="" width="17" height="17">
                                        </button>
                                        <ul v-if="countryOpen" class="country-list" role="listbox">
                                            <li v-for="item in countries" :key="item.code">
                                                <button type="button" role="option" :aria-selected="country === item.code" @click="country = item.code; countryOpen = false">
                                                    {{ item.name }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <input v-model="form.phone" type="tel" name="phone" autocomplete="tel" placeholder="1.123.456.789" aria-labelledby="phone-label">
                                </div>
                            </div>
                            <label class="field">
                                <span>Business Website</span>
                                <input v-model="form.website" type="url" name="website" autocomplete="url" placeholder="Website URL">
                            </label>
                        </div>

                        <div v-else-if="step === 2" class="choices" role="group" aria-label="Services">
                            <section v-for="group in groups" :key="group.title">
                                <h2>
                                    {{ group.title }}
                                    <span v-if="group.accent">{{ group.accent }}</span>
                                </h2>
                                <div class="choice-grid">
                                    <label v-for="item in group.items" :key="item" class="choice" :class="{ 'is-on': hasService(item) }">
                                        <input type="checkbox" :checked="hasService(item)" @change="toggleService(item)">
                                        <img :src="hasService(item) ? '/images/c1d0e.svg' : '/images/32df4.svg'" alt="" width="24" height="24">
                                        {{ item }}
                                    </label>
                                </div>
                            </section>
                        </div>

                        <div v-else-if="step === 3" class="budgets" role="radiogroup" aria-label="Budget">
                            <label v-for="amount in budgets" :key="amount" class="budget" :class="{ 'is-on': form.budget === amount }">
                                <input v-model="form.budget" type="radio" name="budget" :value="amount">
                                <span class="radio" aria-hidden="true"></span>
                                {{ amount }}
                            </label>
                        </div>

                        <label v-else class="field field-note">
                            <span class="visually-hidden">Project details</span>
                            <textarea v-model="form.project" name="project" rows="2" placeholder="Give us some context: your goals, your ideal way to collaborate, etc."></textarea>
                        </label>

                        <div class="quiz-bar">
                            <ol class="steps" aria-label="Progress">
                                <li v-for="n in 4" :key="n" :class="{ 'is-current': step === n, 'is-done': step > n }">
                                    <span>{{ n === step ? 'Step ' + n : 'Step ' + n }}</span>
                                    <i aria-hidden="true"></i>
                                </li>
                            </ol>
                            <div class="quiz-actions">
                                <button v-if="step > 1" type="button" class="quiz-btn" @click="prev">
                                    <img class="arrow-back" src="/images/de13a.svg" alt="" width="15" height="15">
                                    Prev
                                </button>
                                <button v-if="step < 4" type="submit" class="quiz-btn">
                                    Next
                                    <img src="/images/de13a.svg" alt="" width="15" height="15">
                                </button>
                                <button v-else type="submit" class="quiz-btn quiz-btn-submit">submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div v-else class="thanks">
                    <img src="/images/637ad.png" alt="" width="88" height="88">
                    <h1>Thank you!</h1>
                    <p>You’re all set. Our team will review everything and be in touch soon.</p>
                    <Link href="/" class="quiz-btn">Back to Home</Link>
                </div>
            </main>

            <footer class="quiz-footer">
                <img class="quiz-line" src="/images/79248.svg" alt="" width="1218" height="1">
                <div class="quiz-footer-row">
                    <div class="quiz-socials">
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
                    <img class="quiz-footer-logo" src="/images/8eeb8.png" alt="MADHUB" width="90" height="74">
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
    </AppLayout>
</template>
