<template>
    <div class="col-xs-12 col-sm-4">
        <div class="jumbotron text-center">
            <p class="dim">Clients</p>
            <h1>{{ clientsLen }}</h1>
        </div>
    </div>
</template>
<script setup lang="ts">

// defineProps({
//     clientsLen: <Number>
// })

let clientsLen = computed(() => usePage().props.value.clientsLen)
</script>
