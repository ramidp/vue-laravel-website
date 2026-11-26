<script setup>
import { Link } from '@inertiajs/vue3';

const year = new Date().getFullYear();
</script>

<template>
    <footer class="site-footer">
        <div class="container site-footer__inner">
            <Link href="/" class="logo">
                <img src="/images/8eeb8.png" alt="MADHUB">
            </Link>

            <nav class="site-footer__nav">
                <a href="/#services">Services</a>
                <a href="/#about">About Us</a>
                <a href="/#contact">Contact</a>
            </nav>

            <p class="site-footer__copy">&copy; {{ year }} MADHUB. All rights reserved.</p>
        </div>
    </footer>
</template>
