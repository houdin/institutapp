<template>
    <Link href="/" class="navbar-brand text-uppercase">
    <svg class="" width="7.5rem" height="50px">
        <use xlink:href="/sprite.svg?logo#logo"></use>
    </svg>
    <!-- <img :src="$laravel.urls.index +'/assets/images/logos/'+ $laravel.app.logo_w_image" alt="logo"> -->
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3'

</script>
