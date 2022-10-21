<template>
  <div class="nav nav-menu justify-content-end h-100 align-items-center">
    <!-- <li class="nav-item">

    </li> -->
    <div class="nav-item d-flex me-1">
      <div class="nav-link">

        <material-icon @click="searchToggle" name="search" label="Rechercher" class="nav-icon search-icon"></material-icon>
      </div>
    </div>
    <navbar-cart>

    </navbar-cart>

    <div class="nav-item d-flex ms-2">
      <router-link :to="{ name: 'premium.index'}" class="btn btn-base-2 rounded-pill py-1 px-2 small">
        <span class="">Premium</span>
        <!-- <material-icon name="Certificate" label="Premium" class="nav-icon _lg_up search-icon"></material-icon> -->
      </router-link>

    </div>

    <div v-if="!!currentUser?.value?.id" class="menu-item-has-children ul-li-block ms-3">

      <a href="#!">
        <div class="user-nav d-flex">
          <span>{{ currentUser.value.first_name }}</span>
          <material-icon name="user-circle" label="Vous!" class="nav-icon user-icon ms-1"></material-icon>
        </div>

      </a>
      <ul class="sub-menu user-submenu">

        <li class="nav-item" v-if="admin_permission === true">

          <a :href="$laravel.urls.admin_dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'user.account'}">My account</router-link>
        </li>
        <li class="nav-item">
          <router-link :to="{ name: 'user.account'}">Factures</router-link>
        </li>

        <li class="nav-item">
          <a href="" @click.prevent="logout()">Se Deconnecter</a>

        </li>
      </ul>

    </div>

    <div class="nav-item" v-else>
      <!-- @click="$bvModal.show('myModal') -->

      <!-- <b-button @click="showModal" ref="btnShow">Se Connecter</b-button> -->
      <div class="log-in">
        <span class="ms-3">
          <router-link :to="{ name: 'login'}">Se Connecter</router-link>
        </span>
        <!-- <span class="ms-3">
            <router-link :to="{ name: 'register'}">S'inscrire</router-link>
          </span> -->

        <!-- <a id="openLoginModal" data-target="#myModal" @click.prevent="showModal"
                        href="" ref="btnShow">Se Connecter</a> -->

        <!-- <a data-target="#myModal" @click.prevent="showModal"
                        href="" ref="btnShow">Se Connecter</a> -->
      </div>
    </div>

  </div>
</template>

<script setup>
const { computed, ref } = require("@vue/reactivity");
const { inject, onMounted, onBeforeMount } = require("@vue/runtime-core");
const { useStore } = require("vuex");
const store = useStore();

const $filters = inject("$filters");
const $laravel = inject("$laravel");

const currentUser = ref({});

const admin_permission = ref(false);

Event.$on("checkUser", () => {
  //   console.log("EVENT CHECKUSER");
  currentUser.value = computed(() => store.state.CurrentUser.user);
});

const logout = () => {
  axios.post("/logout").then((response) => {
    Event.$emit("update-user-message", response.data.message);

    window.location.replace("/");
  });
};
onBeforeMount(async () => {
  currentUser.value = Laravel.app.user
    ? computed(() => store.state.CurrentUser.user)
    : false;
  admin_permission.value = await $filters.Auth.admin_permission();
});

onMounted(async () => {});

const searchToggle = () => {
  Event.$emit("search-toggle", true);
};

// const showModal = () => {
//   Event.$emit("show.modal", "appModal", "#btnShow");
// };
// const hideModal = () => {
//   Event.$emit("hide.modal", "appModal", "#btnShow");
// };
// const toggleModal = () => {
//   Event.$emit("toggle.modal", "appModal", "#btnToggle");
// };
</script>
