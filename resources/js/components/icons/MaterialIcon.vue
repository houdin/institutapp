<template>
  <span :aria-hidden="decorative" :aria-label="label" class="icon" role="img">
    <svg>
      <use :xlink:href="'/icons.svg?icon#' + name"></use>
      <!-- <title v-if="!decorative">{{ name + ' icon' }}</title> -->
    </svg>
  </span>
</template>

<script setup lang="ts">
/// link
// https://materialdesignicons.com/

// :class="[data.class, data.staticClass]"

const props = defineProps({
  name: {
    type: String,
    default: "Abacus",
  },

  decorative: {
    type: Boolean,
    default: false,
  },
  label: {
    type: String,
  },
});

// const styles = {
//   height: props.size,
//   width: props.size,
// };

// const propsName = props.name[0].toUpperCase() + props.name.substr(1);

// const name_kebab = propsName
//   .replace(/([A-Z])([A-Z])/g, "$1-$2")
//   .replace(/([a-z])([A-Z])/g, "$1-$2")
//   .replace(/[\s_]+/g, "-")
//   .toLowerCase();

// const IconGrp = fxicons[propsName[0]];

// const path =
//   IconGrp[propsName] !== undefined
//     ? IconGrp[propsName].path
//     : fxicons["A"]["Abacus"].path;

// function makeKebab(value) {
//   return value
//     .replace(/([A-Z])([A-Z])/g, "$1-$2")
//     .replace(/([a-z])([A-Z])/g, "$1-$2")
//     .replace(/[\s_]+/g, "-")
//     .toLowerCase();
// }
</script>


