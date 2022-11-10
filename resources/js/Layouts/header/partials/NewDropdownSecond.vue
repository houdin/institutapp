<template>
    <li class="nav-item">
        <Link :href="'/'+item" class="nav-link">{{label}}</Link>
    </li>
</template>

<script setup lang="ts">

defineProps({
    item: String,
    label: String
})

</script>
