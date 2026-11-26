<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',   // Required by the 'confirmed' validation rule
});

// POST /register -> RegisterController@store
function submit() {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <Head title="Register" />

    <AppLayout>
        <section class="auth">
            <div class="auth__card">
                <h1 class="auth__title">Create <span>account</span></h1>
                <p class="auth__subtitle">Join us. It only takes a minute.</p>

                <form class="auth__form" novalidate @submit.prevent="submit">
                    <div class="field">
                        <label for="name">Name</label>
                        <input id="name" v-model="form.name" type="text" autocomplete="name" required autofocus>
                        <span v-if="form.errors.name" class="field__error">{{ form.errors.name }}</span>
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" v-model="form.email" type="email" autocomplete="email" required>
                        <span v-if="form.errors.email" class="field__error">{{ form.errors.email }}</span>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" v-model="form.password" type="password" autocomplete="new-password" required>
                        <span v-if="form.errors.password" class="field__error">{{ form.errors.password }}</span>
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirm password</label>
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password" autocomplete="new-password" required>
                    </div>

                    <button type="submit" class="btn btn--primary btn--lg btn--block" :disabled="form.processing">Register</button>
                </form>

                <p class="auth__switch">
                    Already have an account? <Link href="/login">Log in</Link>
                </p>
            </div>
        </section>
    </AppLayout>
</template>
