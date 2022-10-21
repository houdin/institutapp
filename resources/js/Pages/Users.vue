<template>


    <h1>Users</h1>

    <Nav/>

    <div style="margin-top: 400px">
        <p>The current time is {{ time }}</p>
        <Link href="/users" preserve-scroll class="text-blue-4xl">Refresh</Link>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    time: String
})
</script>
