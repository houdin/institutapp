<template>
  <nav id="nav" :class="{'navbar navbar-expand-lg fixed-top flex-column py-1': true,
  'navbar--hidden': hideNavbar}">
    <div class="container">

      <logo-header></logo-header>

      <div class="collapse navbar-collapse" id="main-navbar">
        <div class="nav-menu ul-li">
          <ul v-if="$laravel.app.custom_menus">

            <li v-for="(value, index) in   $laravel.app.custom_menus" :key="index"
              class="menu-item-has-children ul-li-block">

              <template v-if="typeof value == 'object'">
                <a href="#!"
                  :class="{'nav-link' : true, 'router-link-active router-link-exact-active' : isActive(index, $route.path)  }">{{index}}</a>
                <ul class="sub-menu">
                  <nav-dropdown v-for="(item, index2) in   value" :key="index2" :item="item" :label="index2"
                    :home="$laravel.urls.index">
                  </nav-dropdown>
                </ul>
              </template>
              <template v-else>
                <router-link :to="'/' + value" :id="'menu-' + value" class="nav-link">{{index}}</router-link>

              </template>
            </li>
            <!-- @endforeach -->
          </ul>
        </div>

      </div>
      <right-menu-header class="d-flex"></right-menu-header>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-menu"
        aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div v-click-outside="hide" id="mobile-menu" class="collapse navbar-collapse">
        <div class="nav-menu mobile ul-li-flex">
          <ul v-if="$laravel.app.custom_menus">
            <li v-for="(value, index) in   $laravel.app.custom_menus" :key="index"
              class="menu-item-has-children ul-li-flex">
              <template v-if="typeof value == 'object'">
                <a href="#!"
                  :class="{'nav-link' : true, 'router-link-active router-link-exact-active' : isActive(index, $route.path)  }">{{index}}</a>
                <ul class="sub-menu">
                  <nav-dropdown v-for="(item, index2) in value" :key="index2" :item="item" :label="index2"
                    :home="$laravel.urls.index">
                  </nav-dropdown>
                </ul>
              </template>
              <template v-else>
                <router-link :to="'/' + value" :id="'menu-' + value" class="nav-link">{{index}}</router-link>
              </template>
            </li>
          </ul>
        </div>

      </div>

    </div>

    <search-wrapper class="d-flex"></search-wrapper>

  </nav>

</template>

<script setup lang="ts">
const {
  watch,
  ref,
  watchEffect,
  computed,
  reactive,
  inject,
  onMounted,
  onBeforeUnmount,
  onUnmounted,
} = require("@vue/runtime-core");

const { useRoute } = require("vue-router");

const hideNavbarMobile = ref(true);

const hide = () => {
  $("#mobile-menu").removeClass("show");
};

const mobileNavbarToggle = () => {
  hideNavbarMobile.value = !hideNavbarMobile.value;
};

const menu = inject("$laravel").app.custom_menus;
const menus = {};

const keys = Object.keys(menu);

const hideNavbar = ref(false);
const lastScrollPosition = ref(0);

const limitPosition = 100;
const scrolled = ref(false);
const lastPosition = ref(0);

keys.forEach((key) => {
  if (typeof menu[key] === "object") {
    menus[key.toLowerCase()] = Object.values(menu[key]);
  }
});
// watchEffect()
const route = useRoute();

const isActive = (group, path) => {
  const path_sub = path.substr(1);
  //   console.log(menus.studio);
  if (menus[group.toLowerCase()]) {
    return menus[group.toLowerCase()].indexOf(path_sub) >= 0;
  }
  return false;
};

watch(
  () => route.path,
  (currentPath, prevPath) => {
    if (currentPath) {
    }
  },
  { immediate: true }
);

const onScroll = () => {
  if (
    !document
      .querySelector("#search-wrapper")
      .classList.contains("search--hidden")
  ) {
    Event.$emit("search-toggle", true);
  }
  // Get the current scroll position
  const currentScrollPosition =
    window.pageYOffset || document.documentElement.scrollTop;
  // Because of momentum scrolling on mobiles, we shouldn't continue if it is less than zero
  if (currentScrollPosition < 0) {
    return;
  }
  if (Math.abs(currentScrollPosition - lastScrollPosition.value) < 60) {
    return;
  }
  // Here we determine whether we need to show or hide the navbar
  hideNavbar.value = currentScrollPosition > lastScrollPosition.value;

  hideNavbar.value ? $("#mobile-menu").removeClass("show") : null;
  // Set the current scroll position as the last scroll position
  lastScrollPosition.value = currentScrollPosition;
};

onMounted(() => {
  Event.$on("mobile-nav-toggle", () => {
    mobileNavbarToggle();
  });

  $("#mobile-menu .menu-item-has-children .sub-menu a").on(
    "click",
    function (e) {
      $("#mobile-menu").removeClass("show");
    }
  );

  $("#mobile-menu .menu-item-has-children a").on("click", function (e) {
    e.preventDefault();
    $("#mobile-menu .menu-item-has-children").removeClass("active");
    $(this).parent().addClass("active");
  });
});
window.addEventListener("scroll", () => onScroll());

onUnmounted(() => {
  window.removeEventListener("scroll", () => onScroll());
});
onBeforeUnmount(() => {});
</script>

