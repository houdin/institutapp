<template>
  <div class="shopping-cart-form" :product-id="productId" :type="type">
    <button class="btn btn-sm shadow-none bg-gray-7 border-gray-5" @click="addToCart">
      <span v-if="cartText" class="color-gray-4">Ajouter au panier</span>
      <material-icon v-else name="cart" size="1.5em" classes="color-base-1"></material-icon>
    </button>
  </div>
</template>

<script setup>
import { useStore } from "vuex";
const { ref, reactive } = require("@vue/reactivity");
const { inject, onMounted } = require("@vue/runtime-core");

const store = useStore();

const $laravel = inject("$laravel");

const cart = reactive({});

const props = defineProps({
  productId: {
    type: Number,
  },
  type: {
    type: String,
  },
  cartText: {
    type: Boolean,
    default: false,
  },
});

const postData = {
  product_id: props.productId,
  quantity: 1,
  type: props.type,
};

//const emit = defineEmits(["add-to-cart"]);

const addToCart = () => {
  ajaxPostRequest($laravel.urls.shopping_cart_add, postData);
};

const ajaxPostRequest = (url, data) => {
  axios
    .post(url, data)
    .then((response) => {
      Event.$emit("update-user-message", response.data.message);
      store.dispatch("Cart/getCart");
    })
    .catch((error) => {});
};
</script>
