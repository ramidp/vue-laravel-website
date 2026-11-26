<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const success = computed(() => page.props.flash.newsletter_success);

const form = useForm({
    newsletter_email: '',
});

// POST /newsletter -> NewsletterController@store (saves to subscribers)
function submit() {
    form.post('/newsletter', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <section id="newsletter" class="newsletter">
        <div class="container newsletter__inner">
            <div>
                <h2 class="newsletter__title">Join the newsletter</h2>
                <p class="newsletter__text">Ideas, cases and tips. No spam, unsubscribe anytime.</p>
            </div>

            <form class="newsletter__form" novalidate @submit.prevent="submit">
                <div class="newsletter__row">
                    <input v-model="form.newsletter_email" type="email" placeholder="you@email.com" aria-label="Email" required>
                    <button type="submit" class="btn btn--dark" :disabled="form.processing">Subscribe</button>
                </div>

                <span v-if="form.errors.newsletter_email" class="newsletter__message">{{ form.errors.newsletter_email }}</span>
                <span v-else-if="success" class="newsletter__message">{{ success }}</span>
            </form>
        </div>
    </section>
</template>
