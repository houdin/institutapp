<template>
  <div class="tab-pane container active" id="verification">
    <span class="error-response text-danger"></span>
    <span class="success-response text-success">{{ success }}</span>
    <!-- <span class="success-response text-success">{{(session()->get('flash_success'))}}</span> -->
    <p id="verify_modal_text" class="">

    </p>
    <div class="contact-info mb-2 mx-auto w-50 py-4">
      <div id="verify_btn" class="nws-button text-center white">

      </div>
    </div>

  </div>

  <modal-base hide-footer animation="fadeInDown">

    <template v-slot:header>
      <div class="modal-header-bg"></div>
      <div class="popup-logo">
        <img :src="$laravel.urls.index + '/assets/images/logos/' + $laravel.app.logo_popup" alt="">
      </div>
      <div class="popup-text text-center">
        <div>
          <h2 id="modal_title_login">Verification</h2>
        </div>

      </div>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="hideModal()">×</button>
      <!-- <b-button size="sm" variant="outline-danger" @click="hideModal()">x</b-button> -->
    </template>

    <template v-slot:body>
      <div class="tab-content" id="login-registration">

        <!-- <router-view name="loginview" :currentuser="currentuser"></router-view>
                <router-view name="registerView" :currentuser="currentuser"></router-view>
                <router-view name="authVerificationView" :currentuser="currentuser"></router-view> -->

        <auth-verification></auth-verification>
      </div>

    </template>

    <!-- <template #modal-footer="{ close }">

        </template> -->

    <!-- @push('after-scripts')
    @if (session('openModel'))
        <script>
            $('#myModal').modal('show');
        </script>
    @endif
@endpush -->
  </modal-base>

</template>

<script setup lang="ts">
const { onMounted, watch, nextTick, ref } = require("@vue/runtime-core");
const { useRoute, useRouter } = require("vue-router");

const route = useRoute();
const router = useRouter();

const success = ref("");

const autverify = false;
const prevRoute = ref(null);

onMounted(() => {
  nextTick(() => {
    // lets watch for route changes on our
    // main parent app component.
    if (route.name === "login") {
      Event.$emit("show.modal", "appModal");
    }
    if (route.name === "register") {
      Event.$emit("show.modal", "appModal");
    }
    if (route.name === "teacher.register") {
      Event.$emit("hide.modal", "appModal");
    }
  });
});

watch(
  () => route.name,
  (currentRoute, prevRoute) => {
    if (currentRoute === "login") {
      Event.$emit("show.modal", "appModal");
    }
    if (currentRoute === "register") {
      Event.$emit("show.modal", "appModal");
    }
    if (currentRoute === "teacher.register") {
      Event.$emit("hide.modal", "appModal");
    }
  }
);

const hideModal = () => {
  Event.$emit("hide.modal", "myModal");

  const all_routes = ["login", "register"];

  if (prevRoute.value) {
    console.log("//// PREV ROUTE");
    console.log(prevRoute.value);
    if (all_routes.indexOf(prevRoute.value) !== -1) {
      console.log("__PREV ROUTE AUTH");
      window.location.replace("/");
    } else {
      console.log("__PREV ROUTE REDIRECT");

      window.location.href = prevRoute.value;
    }
  } else {
    console.log("__PREV ROUTE NULL");
    window.location.replace("/");
  }
};
</script>

