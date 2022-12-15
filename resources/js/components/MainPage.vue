<template>
  <!-- <slot :message="message" :errorMessage="errorMessage" :showComponents="showComponents" /> -->
  <metainfo>
    <template v-slot:title="{ content }">{{ content ? `${content} | ${$SITE_NAME}` : `${$SITE_NAME}xx` }}</template>
    <template v-slot:description="{ content }">{{ content ? `${content} | ${$SITE_NAME}` : `${$SITE_NAME}xx`
    }}</template>
  </metainfo>
  <div id="modal-root">

  </div>

  <header-app ref="headerapp">

  </header-app>

  <success-message v-if="showMessage" :message="message">
  </success-message>

  <error-message v-if="showError" :error-message="errorMessage">
  </error-message>

  <main
    :id="`${($filters.Utility.segment(1).length ? $filters.Utility.segment(1) : 'home')}-${($filters.Utility.segments().length > 1 ? 'item' : 'page')}`"
    :class="'container-fluid d-flex flex-column align-items-center ' + ($route.name !== 'home' ? `${$filters.Utility.segment(1)}-${($filters.Utility.segments().length > 1 ? 'item-section' : 'page-section')}` : '') + ' _section_page_ _page_'"
    ref="main">
    <breadcrumbs v-if="$route.name !== 'home'" class="d-slide-small my-2" @prev-bread="routeSlide"></breadcrumbs>
    <svg id="bg-logo-icon" class="d-slide-small"
      style="position: absolute; width:50rem; height:40rem; top: -2rem; color: #2a2c34;">
      <use xlink:href="/sprite.svg?logo#logo-icon"></use>
    </svg>

    <div id="container-master" class="container d-flex flex-column" ref="container">

      <app-title v-if="!showLoading && $route.meta.pageTitle" :text="$route.meta.pageTitle.title"
        :inverse="$route.meta.pageTitle.inverse_color" class="widget-title">
        <template v-if="$route.meta.pageTitle.content" v-slot:content>
          <div class="mb-5">
            {{ $route.meta.pageTitle.content }}
          </div>
        </template>
      </app-title>
      <div id="page-loader" class="w-100 position-absolute d-slide-big ">
        <loader v-show="showLoading"></loader>
      </div>
      <router-view v-if="errorsAxios === null"></router-view>
      <router-view v-else>
        <component :is="'Error' + errorsAxios.status"></component>
      </router-view>

      <router-view name="loginview"></router-view>
      <router-view name="registerview"></router-view>
      <router-view name="authview"></router-view>

    </div>

  </main>

  <vue-progress-bar class="bg-base-2"></vue-progress-bar>

  <footer-app></footer-app>

</template>


<script setup lang="ts">
import { useMeta } from "vue-meta";

useMeta({
  title: "",
  htmlAttrs: { lang: "fr", amp: true },
});

const {
  onMounted,
  computed,
  ref,
  watch,
  reactive,
  watchEffect,
  nextTick,
  onBeforeUnmount,
  onUpdated,
  inject,
  onBeforeUpdate,
  onBeforeMount,
  provide,
  readonly,
} = require("@vue/runtime-core");

const { onBeforeRouteUpdate } = require("vue-router");
const { useStore } = require("vuex");

const { useRoute, useRouter } = require("vue-router");

const height_view = ref(null);

const $filters = inject("$filters");

const container = ref(null);

const currentTabComponent = "*";

const route = useRoute();
const router = useRouter();
const path_route = computed(() => route.path);

const headerapp = ref(null);
const main = ref(null);
// path_route.value = computed(() => route.path);

// const prevRoute = router.options.history.state.back;
const prevRoute = ref("");

const store = useStore();
const message = ref("");
const errorMessage = ref("");

const errorsAxios = ref(null);

const postData = ref(null);

const showMessage = ref(false);
const showError = ref(false);

const lastScrollPosition = ref(0);
const hideNavbar = ref(false);

const $Progress = inject("$Progress");

const showLoading = ref(false);
provide("axiosLoading", readonly(showLoading));

const slideAnimBig = ref("anim-slide-prev-big");
const slideAnimSmall = ref("anim-slide-prev-small");
const routeSlide = () => {
  slideAnimBig.value = "anim-slide-next-big";
  slideAnimSmall.value = "anim-slide-next-small";
};

const clientHeight = computed(() => {
  if (container.value !== null) {
    return container.value.clientHeight;
  }
  return;
});

onMounted(() => {
  Event.$on("remove-item", (value) => {
    removeItem(value);
  });

  nextTick(() => {
    // await $filters.Utility.timeOut();
    // console.log(container.value.clientHeight);
    // console.log(container);

    main.value.style.minHeight =
      parseInt(container.value.clientHeight + 200) + "px";
  });
});

onBeforeRouteUpdate(() => {
  console.log("////// BEFORE  ROUTE UPDATE//////");
});

onBeforeMount(() => {
  //   errorsAxios.value = null;
});

watchEffect(() => {
  //   console.log("////// WATCH EFFECT ROUTE ERROR//////");
  //   console.log(path_route);
  axios.interceptors.request.use(
    (config) => {
      $Progress.start();
      showLoading.value = true;
      return config;
    },
    (error) => {
      return Promise.reject(error);
    }
  );

  axios.interceptors.response.use(
    (response) => {
      showLoading.value = false;
      $Progress.finish();
      errorsAxios.value = null;
      //   console.log("////// WATCH EFFECT AXIOS //////");
      return response;
    },

    //check if we received a 404 and redirect
    (error) => {
      //   console.log(error);

      if (error.response.status > 302) {
        errorsAxios.value = error.response;
        // router.push({ name: "pageNotFound" });
      } else {
        return Promise.reject(error);
      }
    }
  );
});

watch(path_route, (current, prev) => {
  console.log(prev, current);
  if (
    $filters.Utility.segment(1, current) === $filters.Utility.segment(1, prev)
  ) {
    $(".d-slide-big").toggleClass(slideAnimBig.value);
    $(".d-slide-small").toggleClass(slideAnimSmall.value);
    setTimeout(() => {
      $(".d-slide-big").removeClass(slideAnimBig.value);
      $(".d-slide-small").removeClass(slideAnimSmall.value);
      slideAnimBig.value = "anim-slide-prev-big";
      slideAnimSmall.value = "anim-slide-prev-small";
    }, 1100);
  }

  errorsAxios.value = null;
});

if (Laravel.app.user) {
  store.dispatch("CurrentUser/getUser");
}
//   console.log('EVENT HOUIHDODOUDOUD')
//   axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('fxins_token')
//   axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('fxins_token')
//   this.$store.dispatch('CurrentUser/getUser');

Event.$on("update-user-message", (message) => displayMessage(message));
Event.$on("add-to-cart", (message) => addToCart(message));
Event.$on("update-user-error", (error) => displayError(error));

Event.$on("hideModal", () => hideModal());

// Event.$on("show-modal", () => {
//   $("#modal-root").html("");
//   $("#appModal").modal("show");
// });

/**
 * displays a message to the user for 5 seconds
 * @return void
 */
const displayMessage = (msg) => {
  message.value = msg;
  showMessage.value = true;
  setTimeout(() => {
    showMessage.value = false;
  }, 3000);
};

/**
 * displays an error to the user for 5 seconds
 * @return void
 */
const displayError = (error) => {
  console.error(error);
  errorMessage.value = error;
  showError.value = true;

  setTimeout(() => {
    showError.value = false;
  }, 3000);
};

/**
 * gets the post data from the child classes and sets the postData.value property
 * then it calls the ajax post request method to add to send the data to the
 * server
 * @param {value} post data sent from child class
 * @return {void}
 */
const addToCart = (value) => {
  postData.value = value;
  ajaxPostRequest(Laravel.urls.shopping_cart_add);
};

/**
 * ajax request to update the current cart
 * @return {void}
 */
const updateCart = (value) => {
  postData.value = value;
  ajaxPostRequest(Laravel.urls.shopping_cart_update);
};

/**
 * ajax request to remove an item from the current cart
 * @return {void}
 */
const removeItem = (value) => {
  postData.value = { product: value };
  ajaxPostRequest(Laravel.urls.shopping_cart_delete);
};

/**
 * sends a post ajax request to server and sets the message and cart property
 * @param url
 * @param data
 * @return {void}
 */
const ajaxPostRequest = (url) => {
  axios
    .post(url, postData.value)
    .then((response) => {
      updateMessage(response.data);
      // if( url === Laravel.urls.shopping_cart_delete){
      //     this.$store.commit('Cart/removeProductToCart', this.postData.value);
      // }
      store.dispatch("Cart/getCart");
    })
    .catch((error) => {
      updateError(error);
    });
};

const updateMessage = (data) => {
  Event.$emit("update-user-message", data.message);
};

const updateError = (error) => console.log(error);

const login_route = router.resolve({ name: "login" });
const register_route = router.resolve({ name: "register" });
const all_routes = [login_route.href, register_route.href];

const hideModal = () => {
  if (prevRoute.value) {
    if (all_routes.indexOf(prevRoute.value) >= 0) {
      //   router.replace({ name: "home" });
    } else {
      router.go(-1);
    }
  } else {
    // router.push({ name: "home" });
    // console.log("NO PREV ROUTE");
    window.location.replace("/");
  }
};
</script>

