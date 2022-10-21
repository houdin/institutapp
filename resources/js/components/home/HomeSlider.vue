<template>
  <div id="home-slider-container">

    <div class="row slider-section postion-relative" style="z-index: -1">

      <div class="col-lg-2 pe-0 d-none d-md-none d-sm-none d-lg-block">
        <home-download></home-download>
      </div>

      <div class="col-md-8 col-lg-7">
        <sliders :slides="slides"></sliders>

      </div>

      <div class="col-md-4 col-lg-3 ps-0">
        <!-- {{-- //////  HEADER PRODUCT /////// --}} -->
        <div class="slide-product">

          <img v-if="Object.keys(product).length > 0" :src="product.image.url" alt="" style="height:100%; width:auto">

          <div class="mx-auto">
            <span v-if="product" class="text-center">{{product.title}}</span>
          </div>
        </div>
      </div>

    </div>
  </div>

</template>

<script setup>
const { onMounted, ref } = require("@vue/runtime-core");


const slides = ref({});
const product = ref({});
const downloads = ref({});

(async function getSlides() {
  try {
    const response = await axios.get(Laravel.urls.home_slides);
    slides.value = response.data.slides;
  } catch (err) {
    console.log(err);
  }
})();
(async function getDownloads() {
  try {
    const response = await axios.get(Laravel.urls.home_downloads);
    downloads.value = response.data.downloads;
  } catch (err) {
    console.log(err);
  }
})();
(async function getProduct() {
  try {
    const response = await axios.get(Laravel.urls.home_product_head);
    product.value = response.data.product;
  } catch (err) {
    console.log(err);
  }
})();

onMounted(() => {});
</script>
