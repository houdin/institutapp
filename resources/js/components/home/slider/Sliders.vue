<template>
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div v-if="slides" class="carousel-inner">
      <div v-for="slider in slides" :key="slider.id" :class="'carousel-item' + ( slider.id == 1 ? ' active': '') ">
        <img class="d-block img-fluid w-100" :src="$laravel.urls.index +'/assets/images/' + slider.bg_image" alt="First slide">
      </div>

    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <!-- <b-carousel
      id="carousel-header"
      v-model="slide"
      :interval="5000"
      controls
      indicators
      background="#ababab"

      style="text-shadow: 1px 1px 2px #333;"
      @sliding-start="onSlideStart"
      @sliding-end="onSlideEnd"

    >
        <div v-if="slides" class="carousel-inner">

                <b-carousel-slide v-for="(slider, key) in slides" :key="key">
                    <template #img>
                    <img
                        class="d-block img-fluid w-100"
                        :src="$laravel.urls.index +'/assets/images/' + slider.bg_image"
                        alt="image slot"
                    >
                    </template>
                </b-carousel-slide>

        </div>
    </b-carousel> -->
</template>

<script>
export default {
  props: ["slides"],
  data() {
    return {
      slide: 0,
      sliding: null,
    };
  },
  methods: {
    onSlideStart(slide) {
      this.sliding = true;
    },
    onSlideEnd(slide) {
      this.sliding = false;
    },
  },
};
</script>

