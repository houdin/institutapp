<template>
  <div class="container-fluid">
    <div class="row">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Order Date</th>
            <th>Shipped</th>
            <th>Ship Date</th>
            <th>Total</th>
            <th>View Order</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(order, index) in orders" :key="index">
            <td>
              <strong>{{ order.order.order_date }}</strong>
            </td>
            <td>
              <strong>{{ wasShipped(order.order.ship_date) }}</strong>
            </td>
            <td>
              <strong>{{ formatShipDate(order.order.ship_date) }}</strong>
            </td>
            <td>
              <strong>{{ formatShipDate(order.order.cost.total) }}</strong>
            </td>
            <td>
              <a class="btn btn-primary" :href="$laravel.urls.shopping_order_add_api + '/' + order.order.id">View</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- /.row -->
  </div>
</template>

<script>
export default {
  props: ["orders"],

  data() {
    return {};
  },

  mounted() {},

  methods: {
    /**
     * was the packaged shipped
     * @param boolean
     * @return {string}
     */
    wasShipped(boolean) {
      return boolean ? "Yes" : "No";
    },

    /**
     * formats the shipping date.  If empty it returns an empty string
     * @param value
     * @return {string}
     */
    formatShipDate(value) {
      return value ? value : "";
    },
  },
};
</script>
