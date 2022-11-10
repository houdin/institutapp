<template>

    <Link class="text-white hover:underline" :class="{ 'font-bold underline' : active }">
    <slot />
    </Link>

</template>

<script setup lang="ts">

const props = defineProps({ active: Boolean })

</script>

<style scoped>

</style>
