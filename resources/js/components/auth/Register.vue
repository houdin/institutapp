<template>

  <app-modal :show="true" hide-footer noAnim modalstatic>

    <template v-slot:title>
      <div class="modal-header-bg"></div>
      <div class="popup-logo">
        <img :src="$laravel.urls.index + '/assets/images/logos/' + $laravel.app.logo_popup" alt="">
      </div>
      <div class="popup-text text-center">
        <div>
          <h2 id="modal_title_register" style="">S'inscrire</h2>
        </div>

        <p id="modal_head_login" class="" style="">Vous avez déjà un compte?
          <router-link :to="{ name: 'login'}" class="go-login special">Se Connecter</router-link>

          <!-- <a href="" class="go-login special" @click.prevent="switching()">Se connecter</a> -->
        </p>
      </div>
      <material-icon name="close" size="1.5em" classes="color-gray-2 position-absolute align-self-start m-1 end-0" @click="hideModal"></material-icon>
      <!-- <button type="button" class="btn-close position-absolute align-self-start m-1 end-0" data-dismiss="modal" aria-label="Close" @click="hideModal = true"></button> -->
      <!-- <b-button size="sm" variant="outline-danger" @click="hideModal()">x</b-button> -->
    </template>

    <template v-slot:body>
      <div class="tab-content" id="login-registration">

        <!-- <router-view name="loginview" :currentuser="currentuser"></router-view>
                <router-view name="registerView" :currentuser="currentuser"></router-view>
                <router-view name="authVerificationView" :currentuser="currentuser"></router-view> -->

        <registration-form @hide-modal="hideModal"></registration-form>

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
  </app-modal>

</template>

<script setup >
import Swal from "sweetalert2/dist/sweetalert2.js";
const {
  onMounted,
  watch,
  nextTick,
  ref,
  onBeforeUnmount,
  onUnmounted,
  computed,
} = require("@vue/runtime-core");
const { useRoute, useRouter } = require("vue-router");

const route = useRoute();
const router = useRouter();

const autverify = false;
const prevRoute = ref("");

// const hideModal = ref(false);

onMounted(() => {
  nextTick(() => {
    // lets watch for route changes on our
    // main parent app component.
    // if (route.name === "login") {
    //   Event.$emit("show.modal", "appModal");
    // }
    // if (route.name === "register") {
    //   Event.$emit("show.modal", "appModal");
    // }
    // if (route.name === "teacher.register") {
    //   Event.$emit("hide.modal", "appModal");
    // }
  });
});

onUnmounted(() => {
  //   const all_routes = ["login", "register"];
  //   if (prevRoute.value) {
  //     console.log(prevRoute.value);
  //     if (all_routes.indexOf(prevRoute.value) !== -1) {
  //       window.location.replace("/");
  //     } else {
  //       window.location.href = prevRoute.value;
  //     }
  //   } else {
  //     window.location.replace("/");
  //   }
  //   router.go(-1);
});
// onBeforeUnmount();

const hideModal = () => {
  const all_routes = ["/connexion", "/inscription"];
  prevRoute.value = router.options.history.state.back;
  if (prevRoute.value) {
    if (all_routes.indexOf(prevRoute.value) !== -1) {
      window.location.replace("/");
    } else {
      window.location.href = prevRoute.value;
    }
  } else {
    window.location.replace("/");
  }
  setTimeout(() => {}, 100);
};
</script>

