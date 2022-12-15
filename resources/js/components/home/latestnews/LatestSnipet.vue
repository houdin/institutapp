<template>
  <div class="latest-area-content  mb-5">
    <div class="section-title-2 mb30 headline text-left">
      <h4 class="uppercase" v-html="trans.get('labels.frontend.layouts.partials.latest_news_blog')"></h4>
    </div>
    <div class="latest-news-posts" v-if="Object.keys(snipet).length > 0">

      <h3 class="latest-title  color-base-2">
        <router-link :to="{ name:'tipstricks.show', params : { slug : snipet.slug }}">{{snipet.title}}</router-link>

      </h3>
      <p class="latest-content">
        <router-link :to="{ name:'tipstricks.show', params : { slug : snipet.slug }}">{{
        $filters.Text.truncate(snipet.description, 100)}}</router-link>

      </p>
      <div>

        <latest-code></latest-code>
      </div>

      <!-- /post -->

      <div class="view-all-btn ">
        <router-link :to="{ name:'tipstricks.index'}" class="color-base-2">
          {{trans.get('labels.frontend.layouts.partials.view_all_news')}}<i class="fas fa-chevron-circle-right"></i>
        </router-link>

      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
const { computed } = require("@vue/reactivity");

const props = defineProps(["snipet"]);
const snipet = computed(() => props.snipet);
</script>
