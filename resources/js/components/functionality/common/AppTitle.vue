<template>

  <div id="page-title" class="page_title">
    <h1 class="" v-if="inverse"><span class="color-base-2">{{ titleSpread[0]}}</span> {{ titleSpread[1]}}</h1>
    <h1 class="" v-else> {{ titleSpread[0] }}<span class="color-base-2">{{ titleSpread[1] }}</span></h1>

    <slot name="content" class="mb-5"></slot>
  </div>

</template>

<script setup>
const { computed } = require("@vue/reactivity");
const { inject } = require("@vue/runtime-core");

const props = defineProps({
  text: {
    type: String,
    default: "App Default| Title",
  },
  content: {
    type: String,
  },
  inverse: {
    type: Boolean,
  },
});
const titleSpread = computed(() => props.text.split("|"));
</script>

