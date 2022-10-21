<template>
  <div>
    <div class="address-header">
      <button class="btn btn-success" @click="onNewAddress">
        Add an Address
      </button>
    </div>
    <template v-if="showForm" @cancel-modal-form="showForm = false">
      <h3 slot="header">Add a New Address</h3>
      <div slot="body">
        <user-address-form @form-submit="formSubmit" :close="closeForm">
        </user-address-form>
      </div>
    </template>
  </div>
</template>


<script>
export default {
  props: ["refresh"],

  data() {
    return {
      showForm: false,
    };
  },

  methods: {
    /**
     * sets the edit form to true so an address will not be set in the address form
     * and it will toggle the modal form
     * @return {void}
     */
    onNewAddress() {
      this.toggleForm();
    },

    /**
     * closes the form and refreshes the addresses on the screen
     * @return void
     */
    formSubmit() {
      this.refresh();
      this.showForm = false;
    },

    /**
     * toggle the address modal
     * @return void
     */
    toggleForm() {
      this.showForm = !this.showForm;
    },

    closeForm() {
      this.showForm = false;
    },
  },
};
</script>


