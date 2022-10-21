<template>

  <div v-if="tutorial" class="card educcard h-100">
    <div class="card-img-top">
      <img v-if="tutorial.image" :src="$filters.Image.featuredImageUrl(tutorial.image, 5)" alt="">
      <!-- <div v-if="tutorial.free==1" class="trend-badge-3 text-center text-uppercase">
        <i class="fas fa-bolt"></i>
        <span v-html="trans.get('labels.backend.tutorials.fields.free')"></span>
      </div> -->
      <div class="crs-price text-center gradient-bg">

        <span v-if="tutorial.free==1" v-html="trans.get('labels.backend.tutorials.fields.free')"></span>

        <span v-else> {{$laravel.appCurrency + ' ' + tutorial.price}}</span>

      </div>

      <div class="crs-rate ul-li">
        <ul>

          <li v-for="index in tutorial.rating" :key="index"><i class="fas fa-star"></i></li>

        </ul>
      </div>
      <div class="crs-details-btn">

        <router-link :to="{ name: 'tutorials.show', params: { slug : tutorial.slug }}">{{trans.get('labels.frontend.tutorial.tutorial_detail')}}<i class="fas fa-arrow-right"></i></router-link>

      </div>
      <div class="blakish-overlay"></div>
    </div>

    <div class="card-body">
      <h5 class="card-title">
        <router-link :to="{ name: 'tutorials.show', params: { slug: tutorial.slug }}">{{ tutorial.title }}</router-link>
      </h5>
      <div class="card__bar"></div>
      <p class="card-text">{{ $filters.Text.truncate(tutorial.description, 130) }}</p>
      <add-cart-icon :product-id="tutorial.id" type="tutorial" cartText>

      </add-cart-icon>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
    <!-- <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div> -->
  </div>

</template>

<script setup>
const props = defineProps({
  tutorial: {
    default: null,
    type: Object,
  },
});
</script>
