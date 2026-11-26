<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

// Props sent by AccountController@show
defineProps({
    user: { type: Object, required: true },
});
</script>

<template>
    <Head title="My Account" />

    <AppLayout>
        <section class="auth">
            <div class="auth__card">
                <h1 class="auth__title">Hi, <span>{{ user.name }}</span></h1>
                <p class="auth__subtitle">This page is only visible to logged-in users.</p>

                <dl class="account__data">
                    <div>
                        <dt>Name</dt>
                        <dd>{{ user.name }}</dd>
                    </div>
                    <div>
                        <dt>Email</dt>
                        <dd>{{ user.email }}</dd>
                    </div>
                    <div>
                        <dt>Member since</dt>
                        <dd>{{ user.memberSince }}</dd>
                    </div>
                </dl>

                <Link href="/logout" method="post" as="button" class="btn btn--outline btn--lg btn--block">Log out</Link>
            </div>
        </section>
    </AppLayout>
</template>
