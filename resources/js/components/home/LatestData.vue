<template>
  <div id="latest-area" class="latest-area-section">

    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10 col-sm-12">
        <latest-snipet v-if="homeData.snipet" :snipet="homeData.snipet"></latest-snipet>
      </div>
    </div>
    <div class="row py-4 rounded-lg" style="background-color: #222329">
      <div class="col-lg-4 col-md-4  col-sm-6">
        <latest-products v-if="homeData.products" :products="homeData.products"></latest-products>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-6">
        <latest-tutorials v-if="homeData.tutorials" :tutorials="homeData.tutorials"></latest-tutorials>
      </div>

      <div class="col-lg-4 col-sm-6 col-md-4 pt-md-4 pt-lg-0 col-sm-12">
        <latest-posts v-if="homeData.news" :news="homeData.news"></latest-posts>
      </div>
    </div>
  </div>

</template>


<script setup>
const { onMounted, ref, inject } = require("@vue/runtime-core");

const homeData = inject("homeData");

// const snipet = homeData.value.sn;
// const news = ref({});
// const tutorials = ref({});
// const products = ref({});

onMounted(() => {});
</script>
