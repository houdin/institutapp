<template>

  <modal-base hide-footer animation="fadeInDown">

    <template v-slot:header>
      <div class="modal-header-bg"></div>
      <div class="popup-logo">
        <img :src="$laravel.urls.index + '/assets/images/logos/' + $laravel.app.logo_popup" alt="">
      </div>
      <div class="popup-text text-center">
        <div>
          <h2 v-if="route.name === 'register'" id="modal_title_login">Se Connecter</h2>
          <h2 v-else id="modal_title_register" style="">S'inscrire</h2>
        </div>

        <p v-if="route.name === 'login'" id="modal_head_register" class="">Vous n'avez pas encore de compte?
          <router-link :to="{ name: 'register'}" class="go-register special">S'inscrire</router-link>
          <!-- <a href="" class="go-register special" @click.prevent="switching()">S'inscrire</a> -->
        </p>
        <p v-else id="modal_head_login" class="" style="">Vous avez déjà un compte?
          <router-link :to="{ name: 'login'}" class="go-login special">Se Connecter</router-link>

          <!-- <a href="" class="go-login special" @click.prevent="switching()">Se connecter</a> -->
        </p>
      </div>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="hideModal()">×</button>
      <!-- <b-button size="sm" variant="outline-danger" @click="hideModal()">x</b-button> -->
    </template>

    <template v-slot:body>
      <div class="tab-content" id="login-registration">

        <!-- <router-view name="loginview" :currentuser="currentuser"></router-view>
                <router-view name="registerView" :currentuser="currentuser"></router-view>
                <router-view name="authVerificationView" :currentuser="currentuser"></router-view> -->
        <template v-if="autverify === false">

          <login-form v-if="route.name === 'login'" @hide-modal="hideModal"></login-form>

          <registration-form v-if="route.name === 'register'"></registration-form>

        </template>

        <auth-verification v-else></auth-verification>
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

<script setup >
const { onMounted, watch, nextTick, ref } = require("@vue/runtime-core");
const { useRoute, useRouter } = require("vue-router");

const route = useRoute();
const router = useRouter();

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

