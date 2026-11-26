<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.auth.user);

// Anchor links point to sections on the homepage
const navItems = [
    { label: 'Services', href: '/#services' },
    { label: 'Work', href: '/#work' },
    { label: 'About Us', href: '/#about' },
    { label: 'Contact', href: '/#contact' },
    { label: 'Newsletter', href: '/#newsletter' },
];
</script>

<template>
    <header class="site-header">
        <div class="container site-header__inner">
            <Link href="/" class="logo">
                <img src="/images/8eeb8.png" alt="MADHUB">
            </Link>

            <nav class="site-header__nav">
                <a v-for="item in navItems" :key="item.href" :href="item.href">{{ item.label }}</a>
            </nav>

            <div class="site-header__actions">
                <!-- Visitors (not logged in) -->
                <template v-if="!user">
                    <Link href="/login" class="btn btn--ghost">Login</Link>
                    <Link href="/register" class="btn btn--primary">Register</Link>
                </template>

                <!-- Logged-in users -->
                <template v-else>
                    <Link href="/account" class="btn btn--ghost">{{ user.name }}</Link>
                    <Link href="/logout" method="post" as="button" class="btn btn--primary">Logout</Link>
                </template>
            </div>
        </div>
    </header>
</template>
