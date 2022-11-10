<template>
  <Form v-slot="{ errors, values }" @submit.prevent="handleSubmit" id="searchForm" class="search_form">
    <div class="searchBox">
      <Field as="input" type="text" name="search" rules="required" class="searchInput search-field" v-model="search" placeholder="Rechercher…" v-on:keyup="toggleResults" v-on:keyup.esc="close" autocomplete="off" />
      <a href="#" class="header-search-trigger searchButton">
        <span>
          <i class="fas fa-search"></i>
        </span>
      </a>
    </div>
    <div class="search-results" v-show="showResults">
      <ul>
        <li class="p-0 mt-2" v-for="(product, index) in searchResults" :key="index">
          <router-link class="p-0 text-lowercase" :to="{ name:'products.show', params: { slug: product.slug}}">
            <img v-if="product.image_id" :src="product.image_id" />
            <p class="p-0 ps-2">
              <strong>{{ product.title }}</strong>
              <span>{{ product.category_id }}</span>
            </p>
          </router-link>
        </li>
      </ul>
    </div>
  </Form>

  <!-- /.modal-mask -->
</template>


<script setup>
import { inject, onMounted, ref } from "vue";
import { Form, Field, configure } from "vee-validate";

//components = { Form, Field }
onMounted(() => {
  configure({
    validateOnInput: true,
  });
});
const $laravel = inject("$laravel");
const showResults = ref(false);
const search = ref("");
const searchResults = ref([]);

const toggleResults = () => {
  if (search.value.length >= 2) {
    showResults.value = true;
    handleSubmit(search);
    //console.log("HKgsdlglid");
  } else {
    showResults.value = false;
  }
};

const close = () => {
  console.log("Close");
  showResults.value = !showResults.value;
};

const handleSubmit = (val) => {
  //   console.log(values);
  axios
    .post($laravel.urls.shopping_search_products_api, {
      search: val.value,
    })
    .then((response) => {
      searchResults.value = response.data.products;
      console.log(searchResults.value);
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>


