<template>

  <div class="modal fade" id="appModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div :class="'modal-content animate__animated animate__' + animation">

        <!-- Modal Header -->
        <div v-if="!hideHeader" class="modal-header background-style">
          <div class="modal-header-bg"></div>
          <slot name="header">
            default header
          </slot>
        </div>
        <div class="modal-body">
          <slot name="body">default body</slot>
        </div><!-- /.modal-body -->
        <div v-if="!hideFooter" class="modal-footer">
          <slot name="footer">
            default footer
          </slot>
        </div><!-- /.modal-footer -->
      </div>
    </div>
  </div>

</template>

<script setup lang="ts">
const { onMounted } = require("@vue/runtime-core");

const props = defineProps({
  hideFooter: Boolean,
  hideHeader: Boolean,
  animation: {
    default: "bounceIn",
    type: String,
  },
});
// fadeInDown
onMounted(() => {
  var appModal = document.getElementById("appModal");
  var modal_body = document.getElementsByClassName("modal-body");

  if (appModal) {
    appModal.addEventListener("shown.bs.modal", function () {});
  }

  //   setTimeout(() => {
  //     $("#appModal").addClass("show");
  //   }, 500);
});
// const { inject } = require("@vue/runtime-core");

// const props = defineProps(["showModal"]);

// const showModal = inject("showModal");
</script>

