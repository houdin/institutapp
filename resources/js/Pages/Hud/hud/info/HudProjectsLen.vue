<template>
    <div class="col-xs-12 col-sm-4">
        <div class="jumbotron text-center">
            <p class="dim">Projects</p>
            <h1>{{ projectsLen }}</h1>
        </div>
    </div>
</template>
<script setup lang="ts">

// defineProps({
//     clientsLen: <Number>
// })

let projectsLen = computed(() => usePage().props.value.projectsLen)
</script>
