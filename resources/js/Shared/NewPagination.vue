<template>
    <div>
        <Component :is="link.url ? 'Link' :'span'" v-for="link in links" :href="link.url" v-html="link.label"
            class="ml-1" :class="{ 'text-gray-400': !link.url, 'font-bold': link.active}" />
    </div>
</template>

<script setup lang="ts">

defineProps({ links: Array })

</script>
