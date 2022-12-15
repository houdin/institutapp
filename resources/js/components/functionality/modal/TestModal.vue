<template>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>Modal test</h1>
        <p>Press the button to open the modal.</p>
        <teleport to='#modal-root'>
          <app-modal :show="showModal" :on-open="handleOpen" :on-close="handleClose" noAnim>

            <template v-slot:title>
              <h5 class="modal-title">Modal title XX</h5>
            </template>
            <template v-slot:body>
              Some content displayed in the modal.
            </template>
            <template v-slot:footer>
              <button type="button" class="btn btn-secondary" @click="toggleModal" data-dismiss="modal">Close</button>
            </template>

          </app-modal>
        </teleport>

        <button @click="toggleModal">Toggle modal</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const { ref } = require("@vue/reactivity");
const { watch } = require("@vue/runtime-core");

const showModal = ref(false);

const toggleModal = () => {
  showModal.value = !showModal.value;
};
const handleOpen = () => {
  //   console.log("Modal is about to open.");
};
const handleClose = () => {
  //   console.log("Modal has closed.");
  // Make sure to reset the show modal state, as the child component
  // can not change this, parent must do it.
  showModal.value = false;
};
</script>
