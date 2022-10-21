<template>
  <!-- data-bs-backdrop="static" data-bs-keyboard="false" -->

  <div v-if="showRef" :class="{'modal':true, 'fade': noAnim, 'd-block': noAnim ? false : showRef}" :id="modalId" :data-bs-backdrop="modalstatic ? 'static' : null" :data-bs-keyboard="modalstatic ? false : true" tabindex="-1" aria-hidden="true" v-show="showRef" @click="close">
    <div class="modal-dialog">
      <div :class="{'modal-content' : true,
         'animate__animated' :true,
         ['animate__' + animation] : !noAnim }">

        <!-- Modal Header -->
        <div v-if="!hideHeader" class="modal-header background-style">
          <div class="modal-header-bg"></div>
          <slot name="title">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="btn-close" @click="close" data-bs-dismiss="modal" aria-label="Close"></button>
          </slot>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->

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

<script setup>
import {
  computed,
  onBeforeUnmount,
  onMounted,
  ref,
  watch,
} from "@vue/runtime-core";
import Modal from "bootstrap/js/src/modal";

const props = defineProps({
  modalId: {
    type: String,
    default: "appModal",
  },
  show: {
    type: Boolean,
    default: false,
  },
  modalstatic: {
    type: Boolean,
    default: false,
  },
  onOpen: {
    type: Function,
    default: null,
  },
  onClose: {
    type: Function,
    default: null,
  },
  hideFooter: Boolean,
  hideHeader: Boolean,
  noAnim: {
    type: Boolean,
    default: false,
  },
  animation: {
    default: "bounceIn",
    type: String,
  },
});
const showRef = computed(() => props.show);
const appModalEl = ref(null);
const modalInstance = ref({});

onMounted(() => {
  // If the esc button is typed, close modal.
  appModalEl.value = document.querySelector("#" + props.modalId);

  if (appModalEl.value !== null) {
    modalInstance.value = new Modal(appModalEl.value);
    modalInstance.value.show();
  }

  //   document.addEventListener("keydown", handleKeydown());
});

watch(showRef, async (value, old) => {
  if (value) {
    await new Promise((resolve) => {
      setTimeout(resolve, 30);
    });

    appModalEl.value = document.querySelector("#" + props.modalId);

    modalInstance.value = new Modal(appModalEl.value);

    await new Promise((resolve) => {
      setTimeout(resolve, 30);
    });

    open();
  } else if (!value && appModalEl.value !== null) {
    close();
  }
});

onBeforeUnmount(() => {
  //   document.removeEventListener("keydown", handleKeydown());
  if (isDef(modalInstance.value)) {
    modalInstance.value.dispose();
    modalInstance.value = null;
  }
});

function handleKeydown(e) {
  if (showRef.value && e.keyCode === 27) {
    close();
  }
}
function close() {
  console.log("CLOSE MODAL");
  if (props.modalstatic === false) {
    if (isDef(modalInstance.value)) {
      modalInstance.value.hide();
    }
    // Next, call a defined callback.
    if (props.onClose !== null) {
      props.onClose();
    }
  }
}
function open() {
  // First, call a defined callback.
  if (isDef(props.onOpen)) {
    props.onOpen();
  }

  modalInstance.value.show();
}
function isDef(obj) {
  return typeof obj !== undefined && obj !== null;
}

// const router = useRouter();

// const autverify = false;
// const prevRoute = ref(null);

// onMounted(() => {
//   nextTick(() => {
//     // lets watch for route changes on our
//     // main parent app component.
//     if (route.name === "login") {
//       Event.$emit("show.modal", "appModal");
//     }
//     if (route.name === "register") {
//       Event.$emit("show.modal", "appModal");
//     }
//     if (route.name === "teacher.register") {
//       Event.$emit("hide.modal", "appModal");
//     }
//   });
// });

// watch(
//   () => route.name,
//   (currentRoute, prevRoute) => {
//     if (currentRoute === "login") {
//       Event.$emit("show.modal", "appModal");
//     }
//     if (currentRoute === "register") {
//       Event.$emit("show.modal", "appModal");
//     }
//     if (currentRoute === "teacher.register") {
//       Event.$emit("hide.modal", "appModal");
//     }
//   }
// );

// const hideModal = () => {
//   Event.$emit("hide.modal", "myModal");

//   const all_routes = ["login", "register"];

//   if (prevRoute.value) {
//     console.log("//// PREV ROUTE");
//     console.log(prevRoute.value);
//     if (all_routes.indexOf(prevRoute.value) !== -1) {
//       console.log("__PREV ROUTE AUTH");
//       window.location.replace("/");
//     } else {
//       console.log("__PREV ROUTE REDIRECT");

//       window.location.href = prevRoute.value;
//     }
//   } else {
//     console.log("__PREV ROUTE NULL");
//     window.location.replace("/");
//   }
// };
</script>
