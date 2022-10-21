<template>

  <picture>

    <!-- <source v-for="(media, index) in medias" :key="index" :media="media" :srcset="$filters.Image.featuredImageUrl(image, thumbs[index])"> -->

    <img :src="original ? image.url : $filters.Image.featuredImageUrl(image, thumb)" :alt="title">
  </picture>
</template>

<script setup>
const { inject } = require("@vue/runtime-core");

const props = defineProps({
  image: {
    type: Object,
  },
  thumb: {
    type: Number,
  },
  title: {
    type: String,
  },
  thumbs: {
    type: Array,
  },
  original: {
    type: Boolean,
  },
});

const medias = [
  "(max-width: 575.98px)",
  "(max-width: 767.98px)",
  "(max-width: 991.98px)",
  "(max-width: 1199.98px)",
  "(min-width: 1200px)",
];

// const $filters = inject('$filters');
</script>

