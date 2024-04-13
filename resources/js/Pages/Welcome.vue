<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <Link :href="route('login')">Login</Link>

    <h3>Hello World ddd</h3>

    {{ $page.props }}
</template>
