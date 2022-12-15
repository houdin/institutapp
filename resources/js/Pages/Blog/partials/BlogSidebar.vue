<template>
  <div class="col-md-3">
    <div class="side-bar">
      <!-- <div class="side-bar-search">
            <form action="{{route('blogs.search')}}" method="get">
                <input type="text" class="" name="q" placeholder="{{ trans.get('labels.frontend.blog.search_blog') }}">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div> -->

      <div v-if="categories" class="side-bar-widget">
        <h2 class="widget-title text-capitalize">{{ trans.get('labels.frontend.blog.blog_categories') }}</h2>
        <div class="post-categori ul-li-block">
          <ul>

            <template v-if="categories[0]">

              <li v-for="(item, index) in categories" :key="index"
                :class="{'cat-item': true, 'active': ((category !== null && Object.keys(category).length > 0) && (item.slug === category.slug) )}">
                <router-link :to="{ name: 'blogs.category', params: { category: item.slug}}">{{item.name}}</router-link>

              </li>

            </template>
          </ul>
        </div>
      </div>

      <div v-if="popularTags[0]" class="side-bar-widget">
        <h2 class="widget-title text-capitalize">{{ trans.get('labels.frontend.blog.popular_tags') }}</h2>
        <div class="tag-clouds ul-li">
          <ul>

            <li v-for="(item, index) in popularTags" :key="index"
              :class="(tagsSlug(props.tags).indexOf(item.slug) >= 0 ) ? 'active' : ''">
              <router-link :to="{ name: 'blogs.tag', params: { tag: item.slug}}">{{item.name}}</router-link>
              <!-- <a href="{{route('blogs.tag',['tag'=>$item->slug])}}">{{$item->name}}</a> -->
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
const { ref } = require("@vue/reactivity");

const props = defineProps(["popularTags", "categories", "tags", "category"]);
const tagsSlug = (tags) => {
  const ar = [];
  for (item of tags) {
    ar.push(item.slug);
  }
  return ar;
};
</script>
