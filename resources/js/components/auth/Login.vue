<template>

  <app-modal :show="true" hide-footer noAnim modalstatic>

    <template v-slot:title>
      <div class="modal-header-bg"></div>
      <div class="popup-logo">
        <img :src="$filters.asset('/assets/images/logos/' + $laravel.app.logo_popup)" alt="">
      </div>
      <div class="popup-text text-center">
        <div>
          <h2 id="modal_title_login">Se Connecter</h2>
        </div>

        <p id="modal_head_register" class="">Vous n'avez pas encore de compte?
          <router-link :to="{ name: 'register'}" class="go-register special">S'inscrire</router-link>
          <!-- <a href="" class="go-register special" @click.prevent="switching()">S'inscrire</a> -->
        </p>

      </div>
      <button type="button" class="btn-close position-absolute align-self-start m-1 end-0" data-dismiss="modal" aria-label="Close" @click="hideModal"></button>
      <!-- <b-button size="sm" variant="outline-danger" @click="hideModal()">x</b-button> -->
    </template>

    <template v-slot:body>
      <div class="tab-content" id="login-registration">

        <login-form @hide-modal="hideModal"></login-form>
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

<script setup>
const {
  onMounted,
  watch,
  ref,
  nextTick,
  inject,
} = require("@vue/runtime-core");
const { useRoute, useRouter } = require("vue-router");

const route = useRoute();
const router = useRouter();

const $filters = inject("$filters");

const prevRoute = ref("");

onMounted(() => {});

// watch(route.path, (current, prev) => {
//   // prevRoute.value = prev;
//   // console.log("PREVROUTE === " + prevRoute.value);
// });
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
};
</script>

