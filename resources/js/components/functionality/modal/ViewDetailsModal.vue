<template>
  <div class="modal-wrapper">
    <div class="modal-container">
      <div class="modal-body">
        <slot name="body">
          default body
        </slot>
      </div><!-- /.modal-body -->
      <div class="modal-footer">
        <slot name="footer">
          <div class="row">
            <div class="pull-right">
              <button class="btn btn-danger" @click="close">Close</button>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </slot>
      </div><!-- /.modal-footer -->
    </div><!-- /.modal-container -->
  </div><!-- /.modal-wrapper -->
</template>

<script>
export default {
  methods: {
    /**
     * emits message to parent that the user confirmed the action
     * @return {void}
     */
    close() {
      this.$emit("close");
    },
  },
};
</script>

