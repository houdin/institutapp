<template>

  <div v-if="product" class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
    <div class="product  equal-elem card shop-card mb-4 bg-gray-8 rounded-lg overflow-hidden shadow" style="height: 370px">
      <div class="product-thumnail">
        <router-link :to="{ name: 'products.show', params : {slug : product.slug }}">

          <figure>

            <img class="card-img-top" :src="$filters.asset('assets/images/pdts/' + product.image.name)" alt="Card image cap">
          </figure>
        </router-link>
      </div>
      <div class="card-body position-relative">
        <div class="caption">
          <h4 class="card-title">
            <router-link :to="{ name: 'products.show', params : {slug : product.slug }}">{{ product.title }}</router-link>
          </h4>
          <span>Weight : {{ product.weight }} kg</span>
          <h4 :class="product.has_sale ? 'price-cut' : 'price-amount'">
            ${{ product.price }}

            <span v-if="product.has_sale" class="pull-right price-amount">${{ product.sale_price }}</span>
          </h4>

        </div>
        <add-cart-icon :product-id="product.id" @add-to-cart="addToCart" type="product">

        </add-cart-icon>

      </div>
    </div>
  </div><!-- /.col -->

</template>

<script>
export default {
  props: {
    product: {
      type: Object,
    },
  },
  methods: {
    addToCart(value) {
      this.$emit("addToCart", value);
    },
  },
};
</script>


