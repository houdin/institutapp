<template v-if="homeData.portfolios">
  <!-- Start popular formation
       ============================================= -->
  <div id="popular-portfolio" :class="'popular-portfolio-section pb-5' ">

    <div class="section-title mb20 headline text-left ">
      <span class="subtitle text-uppercase" v-html="trans.get('labels.frontend.layouts.partials.view_all_news')">
      </span>
      <h2 v-html="trans.get('labels.frontend.layouts.partials.view_all_news')">
      </h2>
    </div>

    <div id="portfolio-slide-item" class="portfolio-slide owl-carousel owl-theme owl-responsive-1000">
      <div v-for="(item, index) in homeData.portfolios" :key="index" class="portfolio-item-pic-text ">

        <div class="portfolio-pic position-relative mb25">
          <img :src="$filters.Image.featuredImageUrl(item.image, 1)" alt="">
          <div class="overlay"></div>
          <div class="portfolio-details-btn">
            <router-link :to="{ name:'portfolios.show', params:{slug: item.slug} }" class="text-uppercase">{{item.title}}<i class="fas fa-arrow-right"></i>
            </router-link>
          </div>

        </div>

      </div>

    </div>

  </div>
  <!-- End popular formation
        ============================================= -->
</template>
<script setup>
// import carousel from "vue-owl-carousel";

const { ref } = require("@vue/reactivity");
const { onMounted, nextTick, inject } = require("@vue/runtime-core");

const $laravel = inject("$laravel");

const homeData = inject("homeData");

onMounted(async () => {
  portfolioSlide();
});

const portfolioSlide = () => {
  $("#portfolio-slide-item").owlCarousel({
    margin: 10,
    items: 4,
    responsiveClass: true,
    nav: true,
    dots: false,
    autoplay: false,
    navText: [
      "<i class='fas fa-chevron-left'></i>",
      "<i class='fas fa-chevron-right'></i>",
    ],
    smartSpeed: 1000,
    mergeFit: false,
    responsive: {
      0: {
        items: 1,
      },
      400: {
        items: 1,
      },
      600: {
        items: 2,
      },
      790: {
        items: 2,
      },
      800: {
        items: 3,
      },
      992: {
        items: 4,
      },
    },
  });
};
</script>

