<template>
  <div v-if="order">
    <order-total-details v-if="(showTotal && order)" :order="order.cost">

    </order-total-details>
    <user-order-header :order="order">

    </user-order-header>
    <h3>Your Order</h3>
    <ul class="list-group">
      <user-order-item v-for="product in order.products" :key="product.id" :item="product">

      </user-order-item>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["order_id", "need_total"],

  data() {
    return {
      order: null,
      showTotal: false,
    };
  },

  mounted() {
    this.getOrder();
    if (this.need_total) {
      this.showTotal = this.need_total;
    }
  },

  methods: {
    /**
     * performs an ajax request to get the user order
     *
     * @return void
     */
    getOrder() {
      let self = this;
      axios
        .get(
          this.$laravel.urls.shopping_order_add_api +
            "/invoice/" +
            this.order_id
        )
        .then(function (response) {
          self.order = response.data.details.order;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>
