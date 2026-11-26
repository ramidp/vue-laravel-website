<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const success = computed(() => page.props.flash.contact_success);

// useForm keeps the values, validation errors and "processing" state reactive
const form = useForm({
    name: '',
    email: '',
    message: '',
});

// POST /contact -> ContactController@store (saves to contact_messages)
function submit() {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <section id="contact" class="section">
        <div class="container contact">
            <div class="contact__info">
                <h2 class="section__title section__title--left">Let's <span>talk</span></h2>
                <p class="contact__text">Tell us about your brand and what you need. We usually reply within one business day.</p>
            </div>

            <form class="contact__form" novalidate @submit.prevent="submit">
                <div v-if="success" class="form-alert form-alert--success">{{ success }}</div>

                <div class="field">
                    <label for="contact-name">Name</label>
                    <input id="contact-name" v-model="form.name" type="text" placeholder="Your name" required>
                    <span v-if="form.errors.name" class="field__error">{{ form.errors.name }}</span>
                </div>

                <div class="field">
                    <label for="contact-email">Email</label>
                    <input id="contact-email" v-model="form.email" type="email" placeholder="you@email.com" required>
                    <span v-if="form.errors.email" class="field__error">{{ form.errors.email }}</span>
                </div>

                <div class="field">
                    <label for="contact-message">Message</label>
                    <textarea id="contact-message" v-model="form.message" rows="5" placeholder="Your message" required></textarea>
                    <span v-if="form.errors.message" class="field__error">{{ form.errors.message }}</span>
                </div>

                <button type="submit" class="btn btn--primary btn--lg" :disabled="form.processing">
                    {{ form.processing ? 'Sending...' : 'Send Message →' }}
                </button>
            </form>
        </div>
    </section>
</template>
