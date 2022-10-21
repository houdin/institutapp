<template>

  <div class="row">

    <div>

      <template v-if="articles[0]">

        <article class="card postcard dark" v-for="(item, index) in articles" :key="index" :ref="setItemRef" :data-item-ref="item.id">
          <div class="row g-0 card__row">

            <span class="card__gradient position-absolute w-100 h-100"></span>

            <div class="col-md-4 card__img">
              <router-link :to="{ name: 'blogs.show', params: {slug : item.slug} }" class="card__img_link">
                <img v-if="item.image" class="img-fluid" :src="$filters.Image.featuredImageUrl(item.image, 3)" alt="Image Title" />
                <!-- <app-picture v-if="!!item?.image" :class="'postcard__img'" :title="item.title" :image="item.image" :thumb="3" :thumbs="[3,3,2,2,2]"></app-picture> -->
              </router-link>
            </div>

            <div class="col-md-8 card__body">
              <div class="card-body">
                <h1 class="card__title">
                  <router-link class="" :to="{ name: 'blogs.show', params: {slug : item.slug} }">{{item.title}}</router-link>
                </h1>

                <div class="card__subtitle small">
                  <time datetime="2020-05-25 12:00:00">
                    <!-- <i class="fas fa-calendar-alt mr-2"></i>Mon, May 25th 2020 -->
                    <i class="fas fa-calendar-alt mr-2"></i>{{ $date.format(new Date(item.created_at), "E', 'dd MMM yyyy", {locale: $locale()}) }}
                  </time>
                  <!-- <span>{{ format(new Date(item.created_at), 'd/M/Y') }}</span> -->
                </div>
                <div class="card__bar"></div>
                <div class="card__preview-txt">{{ $filters.Text.truncate(item.content, 300)}}</div>
                <ul class="card__tagbox">
                  <li class="tag__item"><i class="fas fa-tag mr-2"></i>Podcast</li>
                  <li class="tag__item"><i class="fas fa-clock mr-2"></i>55 mins.</li>
                  <li class="tag__item play ">
                    <div class="tag__item_btn">
                      <div class="view-all-btn ">
                        <router-link class="color-base-2" :to="{ name: 'blogs.show', params: {slug : item.slug} }">{{ trans.get('labels.general.read_more') }} <i class="fas fa-chevron-circle-right"></i></router-link>
                        <!-- <a class="color-base-2" href="{{route('blogs.index',['slug'=> $item->slug.'-'.$item->id])}}">{{ trans.get('labels.general.read_more') }}  <i
                                class="fas fa-chevron-circle-right"></i></a> -->
                      </div>

                      <!-- <router-link class="fas fa-play mr-2" :to="{ name: 'blogs.show', params: {slug : item.slug} }">Lire l'article</router-link> -->
                      <!-- <a href="#"><i class="fas fa-play mr-2"></i></a> -->
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <!-- <blog-item :item="item" :img="getPalette(item.image.url, index)"></blog-item> -->
            <!-- <div> -->
          </div>
        </article>
      </template>

    </div>
    <pagination v-if="totalItems" :total-items="totalItems" :max-visible-pages="maxVisiblePages" :page="page" :loading="loading" :items-per-page="itemsPerPage" @page-change="pageChange">
    </pagination>
  </div>

  <!-- <h1 class="widget-title text-capitalize"><span>Find </span>Your Course.</h1> -->

  <!-- <div class="blog-content-details">
    <div class="row">
      <div class="col-md-9">
        <div class="blog-post-content">

          <div v-if="articles[0]" class="genius-post-item">
            <div class="blog-list-view">

              <infinite-scroll @refetch="getArticles" :items="articles" :lastPage="last_page" :loading="loading" custom-class="list-blog-item bg-gray-6 shadow">

                <template v-slot:item="{ item }">

                  <blog-item :item="item"></blog-item>

                </template>

              </infinite-scroll>

            </div>

          </div>

        </div>
      </div>
      <blog-sidebar v-if="articles[0]" :popular-tags="popular_tags" :categories="categories" :tags="tag" :category="category"></blog-sidebar>

    </div>
  </div> -->

</template>

<script setup>
import * as Vibrant from "node-vibrant/dist/vibrant.worker";

import { useRoute } from "vue-router";
import { useStore } from "vuex";

const log = (val) => console.log(val);

const {
  onBeforeMount,
  onMounted,
  inject,
  ref,
  onBeforeUpdate,
  watch,
  computed,
  watchEffect,
} = require("@vue/runtime-core");

const route = useRoute();

const store = useStore();

const $filters = inject("$filters");

const page = route.query.page ? ref(parseInt(route.query.page) - 1) : ref(0);
const maxVisiblePages = ref(5);
const totalItems = ref(100);
const loading = ref(false);
const itemsPerPage = ref(10);
const last_page = ref(1);

const articles = ref([]);

const blogs_data = ref({});
const popular_tags = ref([]);
const categories = ref([]);
const tag = ref(null);
const category = ref(null);

const palette = ref([]);
const paletteLenData = ref(0);
const paletteLenLive = ref(0);

const isLoading = ref(false);

const refArticles = ref([]);
const setItemRef = (el) => {
  if (el) {
    refArticles.value.push(el);
  }
};

const itemRefs = ref([]);

const refArticlesCount = computed(() => refArticles.value.length);

const colorsVibrant = ref("");
const colorsDarkVibrant = ref("");

const routeQuery = computed(() => route.query);

const article_id = computed(() => articles.value[0].id);

const admin_role = ref(false);

const pageChange = (page_change) => {
  page.value = page_change;
  //   getFormations(page.value);
};

onBeforeUpdate(() => {
  refArticles.value = [];
  //   palette.value = [];
});

const getArticles = async (page = route.query.page) => {
  let url = "";
  if (route.params.category) {
    const url_cat = Laravel.urls.blogs_category.replace(
      ":category",
      route.params.category
    );
    url = page ? `${url_cat}/?page=${page}` : url_cat;
  } else {
    url = page
      ? `${Laravel.urls.blogs_index}/?page=${page}`
      : Laravel.urls.blogs_index;
  }

  try {
    loading.value = true;
    const response = await axios.get(url);
    articles.value = response.data.blogs.data;
    palette.value = [];
    for (let i = 0; i < articles.value.length; i++) {
      //   console.log(articles.value[i]);
      //   console.log("///// LOOP ELEMENT ///");
      if (articles.value[i].image.colors !== null) {
        const proxy = $filters.Utility.proxy(articles.value[i].image);

        let colors = proxy.colors;
        palette.value.push({ colors, id: articles.value[i].id });
        // palette.value.push({ 'pal' +i : [cols, articles.value[i].id]});

        paletteLenData.value++;
      } else {
        await getPalette(articles.value[i].image, articles.value[i].id);
      }
      //   console.log(element.image.url);
    }

    popular_tags.value = response.data.popular_tags;
    categories.value = response.data.categories;

    blogs_data.value = response.data.blogs;
    // console.log("///// GET ARTICLE ////");

    last_page.value = blogs_data.value.last_page;
    totalItems.value = blogs_data.value.total;
    itemsPerPage.value = blogs_data.value.per_page;

    loading.value = false;
  } catch (err) {
    // console.log(err);
  }
};

watch(paletteLenLive, () => {
  //   if (Object.keys(palette.value).length === refArticlesCount.value) {

  const keysArticles = Object.keys(refArticles.value);

  keysArticles.forEach((key) => {
    //   console.log(itemRefs.value);
    const ref_id = parseInt(refArticles.value[key].dataset.itemRef);
    if (ref_id == palette.value.id) {
      const Obj = Object.values(refArticles.value)[key];
      const pal = palette.value;
      palette_inject(Obj, pal, key);
    }
  });

  //   itemRefs.value = [];

  //   });
});
///refArticlesCount///
watch([paletteLenData, refArticlesCount], () => {
  //   if (Object.keys(palette.value).length === refArticlesCount.value) {
  const keysArticles = Object.keys(refArticles.value);

  keysArticles.forEach((key) => {
    itemRefs.value.push(parseInt(refArticles.value[key].dataset.itemRef));
  });
  const itemRefsValues = Object.values(itemRefs.value);

  if (palette.value.length === keysArticles.length) {
    keysArticles.forEach((key) => {
      const Obj = Object.values(refArticles.value)[key];
      const pal = palette.value[key];
      palette_inject(Obj, pal, key);
    });
  }

  itemRefs.value = [];

  //   });
});

function palette_inject(Ref, pal, key) {
  //BG FLOW
  const flowStyles = Ref.children[0].children[0].style;
  flowStyles.backgroundImage = `linear-gradient(
      ${key % 2 ? "80deg" : "-80deg"},
      ${pal.colors.LightVibrant.hex},
      transparent 50%
    )`;
  flowStyles.filter = `brightness(30%)`;
  //BTN PLAY
  Ref.children[0].children[2].children[0].children[4].children[2].style.background =
    pal.colors.Vibrant.hex;
  //BAR
  Ref.children[0].children[2].children[0].children[2].style.backgroundColor =
    pal.colors.Vibrant.hex;
}

watch(routeQuery, async (newQ, oldQ) => {
  //   console.log("///// WATcH GET ARTICLES");
  //   palette.value = [];
  await getArticles(newQ.page);
  // console.log("//// COUNTER ", counter.value);
});

onBeforeMount(async () => {
  admin_role.value = await $filters.Auth.admin_role();
  //   console.log("///// BEFORE MOUNTED ///////");
  //   loading.value = true;
  await getArticles(routeQuery.page);

  //   loading.value = false;
});

onMounted(() => {
  //   console.log("///// ON MOUNTED ///////");
});

function getPalette(img, post_id) {
  const imgPath = $filters.Image.featuredImageUrl(img, 1);

  Vibrant.from(imgPath)
    .quality(1)
    .maxColorCount(200)
    .getPalette()
    .then(async (promisePalette) => {
      const colors = {};
      let number = 0;

      for (let color in promisePalette) {
        // console.log(promisePalette[color]);
        number = number + 1;
        const type = color;
        // const typeTextColor = promisePalette[color].getTitleTextColor();
        const hex = promisePalette[color].getHex();
        // const hexTextColor = palette[color].getBodyTextColor();

        // const nameTextColor = promisePalette[color].getBodyTextColor();
        colors[type] = {
          number,
          type,
          //   typeTextColor,
          hex,
          //   hexTextColor,
          //   nameTextColor,
        };
      }

      if (admin_role.value === true) {
        axios.post("/user/app-img/colorset", { id: img.id, colors });
      }

      palette.value = { colors, id: post_id };
      paletteLenLive.value++;
      //   console.log("///PAL////");
      //   console.log(palette.value);
    });
}
</script>



