<template>
  <div>
    <span class="postcard__gradient position-absolute w-100 h-100"></span>

    <router-link :to="{ name: 'blogs.show', params: {slug : item.slug} }" class="postcard__img_link">
      <img v-if="item.image" class="postcard__img" :src="img" alt="Image Title" />
    </router-link>

    <div class="postcard__text">
      <h1>
        <router-link class="postcard__title" :to="{ name: 'blogs.show', params: {slug : item.slug} }">{{item.title}}
        </router-link>
      </h1>

      <div class="postcard__subtitle small">
        <time datetime="2020-05-25 12:00:00">
          <!-- <i class="fas fa-calendar-alt mr-2"></i>Mon, May 25th 2020 -->
          <i class="fas fa-calendar-alt mr-2"></i>{{  $date.forma t(new Date(item.created_at), "E', 'dd MMM yyyy",
          {locale: $locale()}) }}
        </time>
        <!-- <span>{{ format(new Date(item.created_at), 'd/M/Y') }}</span> -->
      </div>
      <div class="postcard__bar"></div>
      <div class="postcard__preview-txt">{{ $filters.Text.truncate(item.content, 300)}}</div>
      <ul class="postcard__tagbox">
        <li class="tag__item"><i class="fas fa-tag mr-2"></i>Podcast</li>
        <li class="tag__item"><i class="fas fa-clock mr-2"></i>55 mins.</li>
        <li class="tag__item play ">
          <div class="tag__item_btn">
            <div class="view-all-btn ">
              <router-link class="color-base-2" :to="{ name: 'blogs.show', params: {slug : item.slug} }">{{
              trans.get('labels.general.read_more') }} <i class="fas fa-chevron-circle-right"></i></router-link>
              <!-- <a class="color-base-2" href="{{route('blogs.index',['slug'=> $item->slug.'-'.$item->id])}}">{{ trans.get('labels.general.read_more') }}  <i
                                class="fas fa-chevron-circle-right"></i></a> -->
            </div>

            <router-link class="fas fa-play mr-2" :to="{ name: 'blogs.show', params: {slug : item.slug} }">Lire
              l'article</router-link>
            <!-- <a href="#"><i class="fas fa-play mr-2"></i></a> -->
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
<script setup lang="ts">
const props = defineProps(["item", "img"]);
</script>
