<template>
  <!-- Start of formation section
            ============================================= -->
  <!-- <search-formations></search-formations> -->

  <div class="row">
    <div class="col-md-12">
      <!-- @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif -->

      <!-- <filter-tab></filter-tab> -->

      <div class="genius-post-item">

        <div class="best-crs-area best-crs-v2">

          <template v-if="formations[0]">
            <div class="row">
              <div v-for="(item, index) in formations" :key="index" class="col-md-4">

                <formations-item @add-to-cart="addToCart" :formation="item"></formations-item>

              </div>
            </div>

          </template>

          <h3 v-if="no_formation" v-html="trans.get('labels.general.no_data_available')"></h3>

          <!-- /formation -->

        </div>

        <!-- <div class="couse-pagination text-center ul-li"> -->
        <!-- <pagination v-model="page" :records="last_page" :per-page="1" @paginate="getFormations" /> -->
        <!-- <pagination :data="formations" @pagination-change-page="getResults"></pagination>  -->

      </div>
    </div>
    <pagination :total-items="totalItems" :max-visible-pages="maxVisiblePages" :page="page" :loading="loading" :items-per-page="itemsPerPage" @page-change="pageChange">
    </pagination>

  </div>

  <!-- End of formation section
        ============================================= -->
</template>

<script setup>
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
  //   getFormations(page.value);
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
const formations = ref([]);
const postData = ref("");
const formationsData = ref([]);
// const page = ref(1);
const last_page = ref(1);
const no_formation = ref(false);

const getFormations = async (page = route.query.page) => {
  let url = "";
  if (route.params.category) {
    const url_cat = Laravel.urls.formations_category.replace(
      ":category",
      route.params.category
    );
    url = page ? `${url_cat}/?page=${page}` : url_cat;
  } else {
    url = page
      ? `${Laravel.urls.formations_all}/?page=${page}`
      : Laravel.urls.formations_all;
  }
  try {
    loading.value = true;

    let response = await axios.get(url);
    formations.value = response.data.formations.data;
    formationsData.value = response.data;
    categories.value = response.data.categories;
    last_page.value = response.data.formations.last_page;
    totalItems.value = response.data.formations.total;
    itemsPerPage.value = response.data.formations.per_page;

    no_formation.value = formations.value.length ? false : true;
    loading.value = false;
  } catch (err) {
    no_formation.value = true;
    console.log(err);
  }
};
const routeQuery = computed(() => route.query);

onBeforeMount(async () => {
  //   loading.value = true;
  await getFormations(routeQuery.page);
  //   loading.value = false;
});

onMounted(() => {
  loading.value = true;
  //   await getFormations(routeQuery.page);
  loading.value = false;
  // this.loadCategories();
  // this.loadManufacturers();
  // this.loadPrices();
  // this.loadFormations();

  //console.log(this.formations);
});

watch(
  routeQuery,
  (newQ, oldQ) => {
    getFormations(newQ.page);
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
// const loadFormations = () => {
//   axios
//     .get("api/formations", { params: selected.value })
//     .then((response) => {
//       formations.value = response.data;
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
