<template>
  <div class="latest-area-content  ">
    <div class="section-title-2 mb30 headline text-left">
      <h4 v-html="trans.get('labels.frontend.layouts.partials.latest_news_blog')"></h4>
    </div>
    <div class="latest-news-posts">
      <template v-if="news">
        <div v-for="item in news" :key="item.id" class="card mb-3" style="">
          <div class="row g-0">
            <div class="col-md-4">
              <img :src="$filters.Image.featuredImageUrl(item.image, 1)" class="img-fluid rounded-start" alt="...">
              <div class="blakish-overlay"></div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">
                  <router-link :to="{name:'blogs.index', params: { slug: item.slug }}">
                    {{item.title}}
                  </router-link>
                </h5>
                <p class="card-text">
                  <router-link :to="{name:'blogs.index', params: { slug: item.slug }}">
                    {{ $filters.Text.truncate(item.content, 100)}}
                  </router-link>
                </p>
                <ul>
                  <li v-if="Object.keys(item.comments).length > 1">
                    <small><a href="">
                        <i class="fas fa-comment-dots"></i>{{ Object.keys(item.comments).length }}
                      </a></small>
                  </li>

                </ul>
                <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
              </div>
            </div>
          </div>
        </div>
        <!-- <div v-for="item in news" :key="item.id" class="latest-news-area product">

          <div v-if="item.image" class="products-news-thumbnail position-relative">
            <img :src="$filters.Image.featuredImageUrl(item.image, 1)" class="img-fluid rounded-start" alt="" style="width: 120px; height:90px;">
            <div class="blakish-overlay"></div>
          </div>
          <h3 class="latest-title  color-base-2">
            <router-link :to="{name:'blogs.index', params: { slug: item.slug }}">
              {{item.title}}
            </router-link>

          </h3>
          <p class="latest-content">
            <router-link :to="{name:'blogs.index', params: { slug: item.slug }}">
              {{ $filters.Text.truncate(item.content, 100)}}
            </router-link>

          </p>
          <div class="formation-viewer ul-li">
            <ul>
              <li v-if="Object.keys(item.comments).length > 1">
                <a href="">
                  <i class="fas fa-comment-dots"></i>{{ Object.keys(item.comments).length }}
                </a>
              </li>

            </ul>
          </div>

        </div> -->

      </template>

      <!-- /post -->

      <div class="view-all-btn ">
        <router-link :to="{name:'blogs.index'}" class="color-base-2">
          {{trans.get('labels.frontend.layouts.partials.view_all_news')}}
          <i class="fas fa-chevron-circle-right"></i>
          <!-- Nos Articles -->
        </router-link>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["news"],

  methods: {
    getFeaturedImage(value) {
      //   return this.$options.filters.featuredImage(value, 2);
    },
  },
};
</script>
