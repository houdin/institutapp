<template>
    <div class="col-xs-12 col-sm-4">
        <div class="jumbotron text-center">
            <p class="dim">Tasks</p>
            <h1>{{ tasksLen }}</h1>
        </div>
    </div>
</template>
<script setup lang="ts">

// defineProps({
//     clientsLen: <Number>
// })

let tasksLen = computed(() => usePage().props.value.tasksLen)
</script>
