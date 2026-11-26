<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

// POST /login -> LoginController@store
function submit() {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <Head title="Login" />

    <AppLayout>
        <section class="auth">
            <div class="auth__card">
                <h1 class="auth__title">Welcome <span>back</span></h1>
                <p class="auth__subtitle">Log in to your account.</p>

                <form class="auth__form" novalidate @submit.prevent="submit">
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" v-model="form.email" type="email" autocomplete="email" required autofocus>
                        <span v-if="form.errors.email" class="field__error">{{ form.errors.email }}</span>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" v-model="form.password" type="password" autocomplete="current-password" required>
                        <span v-if="form.errors.password" class="field__error">{{ form.errors.password }}</span>
                    </div>

                    <label class="checkbox">
                        <input v-model="form.remember" type="checkbox">
                        <span>Remember me</span>
                    </label>

                    <button type="submit" class="btn btn--primary btn--lg btn--block" :disabled="form.processing">Log in</button>
                </form>

                <p class="auth__switch">
                    Don't have an account? <Link href="/register">Register</Link>
                </p>
            </div>
        </section>
    </AppLayout>
</template>
