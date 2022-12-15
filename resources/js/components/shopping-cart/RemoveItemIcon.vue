<template>
  <!-- <div :class="mainClass">
        <div class="event-icon">
            <i :class="sizeClass" aria-hidden="true" @click="toggleModal"></i>
        </div>
        <confirm-modal v-show="showModal"
                       @confirm="updateCart"
                       @cancel="toggleModal">
            <h3 slot="header">Remove {{ product }}</h3>
            <p slot="body">Are you sure you want to remove {{ product }} from your order?</p>
        </confirm-modal>
    </div> -->

  <div :class="mainClass">
    <div class="event-icon">
      <i :class="sizeClass" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#appModal"
        @click="isOpen = true"></i>
    </div>

    <confirm-modal v-if="isOpen" @confirm="updateCart">
      <template v-slot:title>
        <div class="popup-text text-center">
          <div>
            <!-- <material-icon></material-icon> -->
            <h3>Remove</h3>
            <!-- <h2 id="modal_title_login">Se Connecter</h2> -->
          </div>
          <p id="modal_head_register" class="">{{  product }}
          </p>
        </div>

      </template>
      <template v-slot:body>
        <p>Are you sure you want to remove {{ product }} from your order?</p>
      </template>

    </confirm-modal>

  </div>

</template>

<script setup lang="ts">
import { computed, ref } from "@vue/reactivity";
import { provide } from "@vue/runtime-core";
import { animateCSS } from "../../frontend/animation";

const props = defineProps(["product_id", "product", "mainClass", "sizeClass"]);
const isOpen = ref(false);

// const close = () => {
//   animateCSS("#modal-root .modal .modal-content", "bounceOut");
//   setTimeout(() => {
//     isOpen.value = false;
//   }, 600);

// };

// const toggleModal = () => {
//   showModal.value = !showModal.value;
// };

const updateCart = () => {
  isOpen.value = false;
  Event.$emit("remove-item", props.product_id);
};
</script>
