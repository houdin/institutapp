<template>
  <div class="latest-area-content  ">
    <div class="section-title-2 mb30 headline text-left">
      <h4 class="uppercase" v-html="trans.get('labels.frontend.layouts.partials.latest_news_blog')"></h4>
    </div>
    <div class="latest-news-posts">
      <div v-for="item in products" :key="item.id" class="latest-news-area product">

        <router-link v-if="item.image" :to="{name:'products.show', params: { slug: item.slug }}">
          <div class="products-news-thumbnail position-relative" :style="'background-image: url('+item.image.url +')'">
            <div class="hover-search">
              <!-- {{--<i class="fas fa-search"></i>--}} -->
            </div>
            <div class="blakish-overlay"></div>
          </div>
        </router-link>

      </div>

      <!-- /post -->

      <div class="view-all-btn ">
        <router-link :to="{name: 'products.index'}" class="color-base-2">
          {{trans.get('labels.frontend.layouts.partials.view_all_news')}}
          <!-- {{--Tous les Produits--}} -->
          <i class="fas fa-chevron-circle-right"></i>
        </router-link>

      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["products"],
};
</script>
