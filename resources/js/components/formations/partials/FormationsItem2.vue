<template>
  <div v-if="formation" class="best-crs-pic-text position-relative">
    <div class="best-crs-pic position-relative">
      <!-- formation.featured_image_url(4) -->
      <img v-if="formation.image" :src="$filters.Image.featuredImageUrl(formation.image, 5)" alt="" width="100%">

      <!-- <div v-if="formation.trending==1" class="trend-badge-2 text-center text-uppercase">
        <i class="fas fa-bolt"></i>
        <span v-html="trans.get('labels.frontend.badges.trending')"></span>
      </div> -->

      <div v-if="formation.free==1" class="trend-badge-3 text-center text-uppercase">
        <i class="fas fa-bolt"></i>
        <span v-html="trans.get('labels.backend.formations.fields.free')"></span>
      </div>

      <div class="crs-price text-center gradient-bg">

        <span v-if="formation.free==1" v-html="trans.get('labels.backend.formations.fields.free')"></span>

        <span v-else> {{$laravel.appCurrency + ' ' + formation.price}}</span>

      </div>

      <div class="crs-rate ul-li">
        <ul>

          <li v-for="index in formation.rating" :key="index"><i class="fas fa-star"></i></li>

        </ul>
      </div>
      <div class="crs-details-btn">

        <router-link :to="{ name: 'formations.show', params: { slug : formation.slug }}">{{trans.get('labels.frontend.formation.formation_detail')}}<i class="fas fa-arrow-right"></i></router-link>

      </div>
      <div class="blakish-overlay"></div>
    </div>
    <div class="best-crs-text">
      <div class="crs-title mb20 headline position-relative">
        <h3>
          <router-link :to="{ name: 'formations.show', params: { slug: formation.slug }}">{{ formation.title }}</router-link>
        </h3>

      </div>
      <!-- <div class="formation-meta">
                <span class="formation-category"><a
                            href="{{route('formations.category',['category'=>$formation->category->slug])}}">{{$formation->category->name}}</a></span>
                <span class="formation-author"><a href="#">{{ $formation->students()->count() }}
                        {{ trans.get('labels.frontend.formation.students') }}</a></span>
            </div> -->

      <add-cart-icon :product-id="formation.id" type="formation" cartText>

      </add-cart-icon>

      <!-- <div class="ratings">
            <p class="pull-right"><small class="text-muted">{{ formation.reviews()->count() }} reviews</small></p>
            <review-stars :stars="'{{ round($formation->reviews()->avg('rating'), PHP_ROUND_HALF_UP) }}'">

            </review-stars>
        </div> -->
      <!-- /.rating -->
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  formation: {
    default: null,
    type: Object,
  },
});
</script>
