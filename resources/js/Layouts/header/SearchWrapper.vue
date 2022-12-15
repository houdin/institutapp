<template>
  <div id="search-wrapper" :class="{'search-wrapper nav-menu' : true, 'search--hidden' : hideSearch}"
    style="z-index: -10">
    <div @click.self="hideSearch = true" class="container d-flex justify-content-center" v-click-outside="hide">
      <!-- <div class="second-menu-nav pt-1">
        <ul id="menu-sub-menu" class="nav ms-3">
          <dropdown-second v-for="(item, label) in $laravel.app.second_menus" :key="item" :home="$laravel.urls.index" :item="item" :label="label"></dropdown-second>


        </ul>
      </div> -->
      <div class="col-sm-12 col-md-6 my-4">
        <Form v-slot="{ errors, values }" @submit.prevent="handleSubmit" id="searchForm" class="search_form">
          <div class="searchBox">
            <input id="searchInput" v-focus type="text" name="search" rules="required" class="searchInput form-control"
              v-model="search" placeholder="Rechercher…" v-on:keyup="toggleResults" v-on:keyup.esc="searchToggle"
              autocomplete="off" />

          </div>

        </Form>
        <div id="search-results" class="search-results" v-show="showResults">
          <ul class="_search-results-list d-flex flex-column">
            <li class="p-0 d-flex _search-results-item" v-for="(product, index) in searchResults" :key="index">
              <router-link class="_search-result-link p-0 text-lowercase"
                :to="{ name:'products.show', params: { slug: product.slug}}">
                <img v-if="product.image" :src="$filters.Image.featuredImageUrl(product.image, 1)" />

                <span class="_search-result-span"><span class="badge bg-gray-5 color-base-2">{{ product.category_id
                }}</span>
                  <span :id="`_sr_${index}`" class="ms-2">{{ product.title }}</span></span>

              </router-link>
            </li>
          </ul>
        </div>
        <!-- <search-header :token="csrfToken">
        </search-header> -->

      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import {
  inject,
  nextTick,
  onBeforeMount,
  onBeforeUnmount,
  onMounted,
  onUpdated,
  ref,
} from "vue";
import { Form, Field, configure } from "vee-validate";

const hideSearch = ref(true);

//components = { Form, Field }
onMounted(() => {
  Event.$on("search-toggle", () => {
    searchToggle();
  });
  configure({
    validateOnInput: true,
  });
});

const hide = () => {
  hideSearch.value = true;
};

const searchToggle = () => {
  hideSearch.value = !hideSearch.value;

  search.value = "";
  searchResults.value = [];
};
const $laravel = inject("$laravel");
const showResults = ref(false);
const search = ref("");
const searchResults = ref([]);

const toggleResults = async () => {
  if (search.value.length >= 2) {
    showResults.value = true;
    handleSubmit(search);

    //console.log("HKgsdlglid");
  } else {
    showResults.value = false;
  }
};

function highlight(text, key) {
  let inputText = document.querySelector("#_sr_" + key);
  let innerHTML = inputText.innerHTML;
  let index = innerHTML.indexOf(text);
  if (index >= 0) {
    innerHTML =
      innerHTML.substring(0, index) +
      "<span class='_hlight color-base-2'>" +
      innerHTML.substring(index, index + text.length) +
      "</span>" +
      innerHTML.substring(index + text.length);
    inputText.innerHTML = innerHTML;
  }
}
const handleSubmit = (val) => {
  //   console.log(values);
  axios
    .post($laravel.urls.shopping_search_products_api, {
      search: val.value,
    })
    .then(async (response) => {
      searchResults.value = response.data.products;

      await new Promise((resolve) => {
        setTimeout(resolve, 30);
      });
      const keys = Object.keys(searchResults.value);

      keys.forEach((key) => {
        highlight(search.value, key);
      });

      //   console.log(searchResults.value);
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>


