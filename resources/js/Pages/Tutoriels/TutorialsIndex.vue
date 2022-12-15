<template>
  <div>

    <search-on-page></search-on-page>
    <filter-type></filter-type>
    <div class="row row-cols-1 row-cols-md-4 g-4 ">

      <template v-if="tutorials[0]">

        <div v-for="(item,   index) in tutorials" :key="index" class="col mb40">

          <tutorials-item @add-to-cart="addToCart" :tutorial="item"></tutorials-item>

        </div>

      </template>

      <h3 v-if="  no_tutorial" v-html="trans.get('labels.general.no_data_available')"></h3>

      <!-- /tutorial -->

      <!-- <div class="couse-pagination text-center ul-li"> -->
      <!-- <pagination v-model="page" :records="last_page" :per-page="1" @paginate="getTutorials" /> -->
      <!-- <pagination :data="tutorials" @pagination-change-page="getResults"></pagination>  -->

    </div>
    <pagination :total-items="totalItems" :max-visible-pages="maxVisiblePages" :page="pag  e" :loading="loadi  ng"
      :items-per-page="itemsPerPage" @page-change="pageChange">
    </pagination>

  </div>

</template>

<script setup lang="ts">
const { reactive, ref, computed } = require("@vue/reactivity");
const {
  onMounted,
  inject,
  onBeforeMount,
  watch,
} = require("@vue/runtime-core");
const { useRoute } = require("vue-router");
const { useStore } = require("vuex");

const route = useRoute();

const page = route.query.page ? ref(parseInt(route.query.page) - 1) : ref(0);
const maxVisiblePages = ref(5);
const totalItems = ref(100);
const loading = ref(false);
const itemsPerPage = ref(10);

function pageChange(page_change) {
  page.value = page_change;
  //   getTutorials(page.value);
}

const store = useStore();
const homeData = ref({});

const prices = ref([]);
const manufacturers = ref([]);
const categories = ref([]);
// const loading = ref(true);
const selected = reactive({
  prices: [],
  categories: [],
  manufacturers: [],
});
const tutorials = ref([]);
const postData = ref("");
const tutorialsData = ref([]);
// const page = ref(1);
const last_page = ref(1);
const no_tutorial = ref(false);

const getTutorials = async (page = route.query.page) => {
  let url = "";
  if (route.params.category) {
    const url_cat = Laravel.urls.tutorials_category.replace(
      ":category",
      route.params.category
    );
    url = page ? `${url_cat}/?page=${page}` : url_cat;
  } else {
    url = page
      ? `${Laravel.urls.tutorials_all}/?page=${page}`
      : Laravel.urls.tutorials_all;
  }
  try {
    loading.value = true;

    let response = await axios.get(url);
    tutorials.value = response.data.tutorials.data;
    tutorialsData.value = response.data;
    categories.value = response.data.categories;
    last_page.value = response.data.tutorials.last_page;
    totalItems.value = response.data.tutorials.total;
    itemsPerPage.value = response.data.tutorials.per_page;

    no_tutorial.value = tutorials.value.length ? false : true;
    loading.value = false;
  } catch (err) {
    no_tutorial.value = true;
    console.log(err);
  }
};
const routeQuery = computed(() => route.query);

onBeforeMount(async () => {
  //   loading.value = true;
  await getTutorials(routeQuery.page);
  //   loading.value = false;
});

onMounted(() => {
  loading.value = true;
  //   await getTutorials(routeQuery.page);
  loading.value = false;
  // this.loadCategories();
  // this.loadManufacturers();
  // this.loadPrices();
  // this.loadTutorials();

  //console.log(this.tutorials);
});

watch(
  routeQuery,
  (newQ, oldQ) => {
    getTutorials(newQ.page);
  },
  { immediate: true }
);

// const loadCategories = () => {
//   axios
//     .get("api/categories", { params: _.omit(selected.value, "categories") })
//     .then((response) => {
//       categories.value = response.data;
//     })
//     .catch((error) => {
//       console.error(error);
//     });
// };
// const loadManufacturers = () => {
//   axios
//     .get("api/manufacturers", {
//       params: _.omit(selected.value, "manufacturers"),
//     })
//     .then((response) => {
//       manufacturers.value = response.data;
//       loading.value = false;
//     })
//     .catch((error) => {
//       console.error(error);
//     });
// };
// const loadPrices = () => {
//   axios
//     .get("api/prices", { params: _.omit(selected.value, "prices") })
//     .then((response) => {
//       prices.value = response.data;
//       loading.value = false;
//     })
//     .catch((error) => {
//       console.error(error);
//     });
// };
// const loadTutorials = () => {
//   axios
//     .get("api/tutorials", { params: selected.value })
//     .then((response) => {
//       tutorials.value = response.data;
//       loading.value = false;
//     })
//     .catch((error) => {
//       console.error(error);
//     });
// };
/**
 * ajax request to update the current cart
 * @return {void}
 */
const updateCart = (value) => {
  postData.value = value;
  ajaxPostRequest(Laravel.urls.shopping_cart_update);
};

const ajaxPostRequest = (url) => {
  axios
    .post(url, postData.value)
    .then((response) => {
      updateMessage(response.data);
      store
        .dispatch("Cart/getCart")
        .then(() => {})
        .catch((error) => console.error(error));
    })
    .catch((error) => {
      updateError(error);
    });
};
/**
 * gets the post data from the child classes and sets the postData property
 * then it calls the ajax post request method to add to send the data to the
 * server
 * @param {value} post data sent from child class
 * @return {void}
 */
const addToCart = (value) => {
  postData.value = value;
  ajaxPostRequest(Laravel.urls.shopping_cart_add);
};

const updateMessage = (data) => {
  cart.value = data.cart;
  Event.$emit("update-user-message", data.message);
};

const updateError = () => {
  console.log(error);
};
</script>

