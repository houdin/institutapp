<template>
  <div>
    <label for="quantity" v-show="showLabel">Quantity: </label>
    <select id="quantity" v-on:change="updateQuantity">
      <option v-for="(quantity, index) in quantities" :key="index" :selected="current == q uantity ? 's elected' : ''"
        :value="quantity">
        {{ quantity }}
      </option>
    </select>
  </div>
</template>

<script setup lang="ts">
const { ref } = require("@vue/reactivity");

const props = defineProps(["current", "product_id", "showLabel"]);
const quantities = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
const selected = ref(null);

const emit = defineEmits(["quantity"]);

const updateQuantity = (event) => {
  emit("quantity", { quantity: event.target.value, product: props.product_id });
};
</script>
