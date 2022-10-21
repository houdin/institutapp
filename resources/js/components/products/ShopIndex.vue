<template>

  <div id="main" class="row">
    <div class="col-md-12 wrap-breadcrumb">
      <ul>
        <li class="item-link"><a href="#" class="link">home</a></li>
        <li class="item-link"><span>Digital & Electronics</span></li>
      </ul>
    </div>
    <div class="col-md-3">
      <shop-sidebar></shop-sidebar>
    </div>
    <div class="col-md-9">

      <shop-carousel></shop-carousel>

      <div v-if="products.length" class="row">

        <shop-products-item v-for="product in products" :key="product.id" @add-to-cart="addToCart" :product="product"></shop-products-item>

      </div>
      <h1 v-else>No Products are available</h1>
    </div>
  </div>

  <div class="row my-4 mx-auto">
    <pagination v-if="products.length" v-model="page" :records="records" :per-page="perPage" @paginate="getProducts(page)" />

    <!-- {{ $products->links() }} -->
  </div>
  <!-- /.row -->

</template>

<script>
export default {
  data() {
    return {
      prices: [],
      manufacturers: [],
      categories: [],
      loading: true,
      selected: {
        prices: [],
        categories: [],
        manufacturers: [],
      },
      products: [],
      productsData: {},
      page: 1,
      perPage: 10,
      records: 10,
    };
  },
  emits: ["pagination"],

  created() {},
  watch: {
    // selected: {
    //     handler: function(){
    //         this.loadCategories();
    //         this.loadManufacturers();
    //         this.loadPrices();
    //         this.loadFormations();
    //     },
    //     deep: true
    // }
  },
  mounted() {
    // this.loadCategories();
    // this.loadManufacturers();
    // this.loadPrices();
    // this.loadFormations();
    this.getProducts();
    //console.log(this.formations);
  },
  methods: {
    debug(value) {
      console.log(value);
    },
    loadCategories() {
      axios
        .get("api/categories", { params: _.omit(this.selected, "categories") })
        .then((response) => {
          this.categories = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    loadManufacturers() {
      axios
        .get("api/manufacturers", {
          params: _.omit(this.selected, "manufacturers"),
        })
        .then((response) => {
          this.manufacturers = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    loadPrices() {
      axios
        .get("api/prices", { params: _.omit(this.selected, "prices") })
        .then((response) => {
          this.prices = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    loadFormations() {
      axios
        .get("api/formations", { params: this.selected })
        .then((response) => {
          this.formations = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    getProducts(page = 1) {
      axios
        .get(`${this.$laravel.urls.products_all}/?page=${page}`)
        .then((response) => {
          this.products = response.data.products.data;
          this.productsData = response.data;
          this.perPage = response.data.products.per_page;
          this.records = response.data.products.total;
          console.log(this.productsData);
          this.categories = response.data.categories;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getFeaturedImage(value) {
      return this.$options.filters.featuredImage(value, 2);
    },

    /**
     * ajax request to update the current cart
     * @return {void}
     */
    updateCart(value) {
      this.postData = value;
      this.ajaxPostRequest(this.$laravel.urls.shopping_cart_update);
    },
    /**
     * ajax request to remove an item from the current cart
     * @return {void}
     */
    // removeItem(value) {
    // this.postData = { product: value };
    // this.ajaxPostRequest(this.$laravel.urls.shopping_cart_delete);

    // },

    /**
     * sends a post ajax request to server and sets the message and cart property
     * @param url
     * @param data
     * @return {void}
     */
    ajaxPostRequest(url) {
      axios
        .post(url, this.postData)
        .then((response) => {
          this.updateMessage(response.data);
          this.$store
            .dispatch("Cart/getCart")
            .then(() => {})
            .catch((error) => console.error(error));
        })
        .catch((error) => {
          this.updateError(error);
        });
    },
    /**
     * gets the post data from the child classes and sets the postData property
     * then it calls the ajax post request method to add to send the data to the
     * server
     * @param {value} post data sent from child class
     * @return {void}
     */
    addToCart(value) {
      this.postData = value;
      this.ajaxPostRequest(this.$laravel.urls.shopping_cart_add);
    },

    updateMessage(data) {
      this.cart = data.cart;
      Event.$emit("update-user-message", data.message);
    },

    updateError() {
      console.log(error);
    },
  },
};
</script>

