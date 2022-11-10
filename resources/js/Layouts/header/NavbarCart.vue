<template>
  <div class="nav-item dropdown">
    <a href="#" class="nav-link d-flex" role="button" data-bs-toggle="dropdown" id="cart-viewer" aria-expanded="false">
      <material-icon name="cart" size="1.4em" class="nav-icon cart-icon"></material-icon>

      <span v-if="productsCount > 0" class="badge bg-danger">{{ productsCount }}</span>

    </a>
    <div class="shopping-cart-drop dropdown-menu">
      <ul class="pt-3 ps-0" aria-labelledby="cart-viewer">

        <!-- <li class="dropdown-item dropdown-title">
        {{ getTotalMessage() }}
      </li> -->
        <template v-if="productsCount > 0">

          <li class="dropdown-item" v-for="(product, index) in products" :key="index">
            <img class="dropdown-item-image" :src="product.image" :alt="'Image of ' + product.title" />
            <div class="dropdown-item-info">
              <p class="text-wrap lh-1">
                {{ product.title }}
              </p>
              <p>Price: {{ product.total }}</p>
            </div>
            <!-- <div class="dropdown-quantity">
            <select-cart-quantity v-if="product.attributes.type === 'product'" :current="product.quantity" :product_id="product.id" @quantity="updateQuantity">
            </select-cart-quantity>
          </div> -->
            <remove-item-icon :product_id="product.id" :product="product.title" :mainClass="'remove-item-icon'" :sizeClass="'fa fa-times'">
            </remove-item-icon>
            <hr />
          </li>

        </template>

      </ul>
      <div class="dropdown-item dropdown-button mt-2">
        <router-link :to="{ name: 'select_address' }" class="btn btn-success btn-sm me-2">Check Out</router-link>
        <router-link :to="{ name: 'edit_order' }" class="btn btn-warning btn-sm pull-right">Edit Order</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
const { ref, computed } = require("@vue/reactivity");
const { useStore } = require("vuex");

const store = useStore();
const props = defineProps(["checkout_page"]);

store.dispatch("Cart/getCart");

const products = computed(() => store.state.Cart.products);

const productsCount = computed(() => products.value.length);

const information = computed(() => store.state.Cart.information);

const emit = defineEmits(["update-quantity"]);

const getTotalMessage = () => {
  let message = information.value.count + " Item";
  if (information.value.count != 1) {
    message += "s";
  }
  message += " with total of $" + information.value.total;
  return message;
};

const updateQuantity = (value) => {
  emit("update-quantity", value);
};
</script>
