<template>
  <li :class="buttonClasses">
    <i v-if="loading" class="fa fa-spinner fa-spin" />
    <button v-else class="page-link" :disabled="disabled" :title="title" @click="pageChange" v-html="html" />
  </li>

</template>

<script setup>
const { computed } = require("@vue/reactivity");

const props = defineProps({
  page: {
    type: [Number, String],
    required: true,
  },

  active: {
    type: Boolean,
    default: false,
  },

  disabled: {
    type: Boolean,
    default: false,
  },

  html: {
    type: String,
    required: true,
  },

  title: {
    type: String,
    default: "",
  },

  loading: {
    type: Boolean,
    default: false,
  },

  disableStyling: {
    type: Boolean,
    default: false,
  },
});
const emit = defineEmits(["page-change"]);

const buttonClasses = computed(() => {
  if (props.disableStyling) {
    return {};
  }

  return {
    // "focus:outline-none": true,
    // "ms-1": true,
    // "leading-normal": true,
    // "w-6": true,
    "page-item": true,
    "bg-base-2": props.active,
    "color-balck": props.active,
    "cursor-default": props.active || props.disabled,
    "bg-gray-5": props.disabled && props.page !== "...",
    "text-gray": props.disabled && props.page !== "...",
    "hover:bg-gray-3": !props.active && !props.disabled,
  };
});

const pageChange = () => {
  console.log(props.page);
  if (props.page === "..." || props.disabled || props.active) {
    return;
  }

  emit("page-change");
};
</script>
