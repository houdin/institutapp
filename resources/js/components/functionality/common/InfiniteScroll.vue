<template>
  <!-- <infinite-scroll @refetch="getFormations" :items="formations" :lastPage="last_page" :row="true" custom-class="col-md-4">

                    <template v-slot:item="{ item }">

                      <formations-item @add-to-cart="addToCart" :formation="item"></formations-item>

                    </template>

                  </infinite-scroll> -->

  <div :class="row ? 'row' : ''">
    <div v-for="(item, index) in items" :key="index" :class="customClass + ' _infinite_scroll_for_'">

      <slot name="item" v-bind:item="item" />

    </div>
    <div v-if="items.length" v-observe-visibility="handleScrolledToBottom"></div>
  </div>
</template>

<script setup lang="ts">
const { ref } = require("@vue/reactivity");

const props = defineProps({
  row: {
    default: false,
  },
  items: {
    required: true,
    type: Array,
  },
  customClass: {
    type: String,
  },
  lastPage: {
    required: true,
    type: Number,
  },
});

const page = ref(1);
const emit = defineEmits(["refetch"]);

const handleScrolledToBottom = (isVisible) => {
  if (page.value === props.lastPage) {
    return;
  }
  if (!isVisible) {
    return;
  }
  console.log("INFINITE SCROLL");

  page.value++;
  emit("refetch", page.value);
};
</script>
