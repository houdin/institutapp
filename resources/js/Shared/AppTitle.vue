<template>

    <div id="page-title" class="page_title">
        <h1 :class="classes" v-if="inverse"><span class="text-base-200">{{ titleSpread[0] }}</span> {{
                titleSpread[1]
        }}
        </h1>
        <h1 :class="classes" v-else> {{ titleSpread[0] }}<span class="text-base-200">{{ titleSpread[1] }}</span>
        </h1>

        <slot />
    </div>


</template>

<script setup lang="ts">

const props = defineProps({
    title: {
        type: String,
        default: "App Default| Title",
    },
    classes: String,
    inverse: {
        type: Boolean,
    },
});
const titleSpread = computed(() => props.title.split("|"));
</script>

