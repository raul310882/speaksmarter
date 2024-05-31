<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex justify-center text-xl text-white bg-black">
    <Link :href="route('login')">Login</Link>
    </div>
</template>
