<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <div class="pull-right close-modal" @click="cancel">
            <i class="fa fa-times" aria-hidden="true" role="button" @click="cancel"></i>
          </div>
          <slot name="header">
            default header
          </slot>
        </div><!-- /.modal-header -->
        <div class="modal-body">
          <slot name="body">
            default body
          </slot>
        </div><!-- /.modal-body -->
      </div><!-- /.modal-container -->
    </div><!-- /.modal-wrapper -->
  </div><!-- /.modal-mask -->
</template>

<script>
export default {
  props: [],

  methods: {
    /**
     * emits message to parent that the user confirmed the action
     * @return {void}
     */
    confirm() {
      this.$emit("confirm-cart-modal-form");
    },

    /**
     * emits message to the parent class that the user canceled the action
     * @return {void}
     */
    cancel() {
      this.$emit("cancel-modal-form");
    },
  },
};
</script>

