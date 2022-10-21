<template>

  <!-- Start of formation details section
        ============================================= -->
  <div v-if="!!data?.formation" class="row">
    <!-- <div v-if="Object.keys(data).length > 0" class="d-flex">

      <div v-if="Object.keys(data.formation.image).length > 0" class="formation-single-pic mb30" :style="'background-image: url(' + data.formation.image.url +')'">



      </div>

    </div> -->

    <!-- @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif -->

    <div class="crs-details-item border-bottom-0 mb-0">

      <div class="crs-single-text">
        <div class="crs-title mt10 headline position-relative">
          <h3>
            <router-link v-if="formation.slug" :to="{ name: 'formations.show', params: { slug:formation.slug }}"><b>{{formation.title}}</b></router-link>

            <span v-if="!!formation?.trending == 1" class="trend-badge text-uppercase ">
              {{ trans.get('labels.frontend.badges.trending')}}<i class="fas fa-bolt"></i></span>

          </h3>
        </div>
        <div class="crs-details-content">
          <p v-if="formation.description">
            {{ formation.description }}
          </p>
        </div>

      </div>
    </div>
    <div class="crs-single-pic d-flex align-items-center overflow-hidden mb30">
      <img v-if="!!formation?.image" :src="$filters.Image.featuredImageUrl(formation.image, 5)" class="w-100" alt="">
    </div>
    <div class="col-md-8">
      <div class="crs-details-item border-bottom-0 mb-0">

        <div class="crs-single-text">

          <media-formation :media-video="formation.media_video"></media-formation>

          <div v-if="!!formation?.formation_timeline && formation.formation_timeline.length > 0" class="crs-details-category ul-li">
            <span class="float-none" v-html="trans.get('labels.frontend.formation.formation_timeline')"></span>
          </div>

        </div>
      </div>
      <!-- /formation-details -->

      <div class="affiliate-market-guide mb65">

        <div v-if="!!formation?.formation_timeline && formation.formation_timeline.length > 0" class="affiliate-market-accordion">
          <modules-formation :modules="formation.formation_timeline" :completed-modules="completed_modules"></modules-formation>
        </div>
      </div>
      <!-- /market guide -->

      <!-- <div v-if="Object.keys(data.purchased_formation).length > 0" class="couse-comment">
          <purchased-formation :purchased="data.purchased_formation"></purchased-formation>
        </div> -->

      <!-- <div v-if="Object.keys(data.formation.bundles).length > 0" class="crs-details-category ul-li mt-5">
          <h3 class="float-none text-dark">{{trans.get('labels.frontend.formation.available_in_bundles')}}</h3>
        </div>

        <bundles-formation v-if="Object.keys(data.formation.bundles).length > 0" :bundles="data.formation.bundles"></bundles-formation> -->
    </div>

    <div class="col-md-4">
      <sidebar-formation :formation="formation" :purchased="purchased_formation" :continue-formation="continue_formation"></sidebar-formation>
    </div>

    <!-- End of formation details section
        ============================================= -->
  </div>
</template>

<script setup>
import Plyr from "plyr";
// import polyfilled from 'https://cdn.plyr.io/3.5.3/plyr.polyfilled.js'

import { useRoute, useRouter } from "vue-router";
import { ref } from "@vue/reactivity";
import { inject, onBeforeMount, onMounted } from "@vue/runtime-core";

const player = new Plyr("#player");

const $filters = inject("$filters");

const route = useRoute();
const router = useRouter();

const data = ref([]);
const formation = ref([]);
const purchased_formation = ref([]);
const continue_formation = ref([]);
const completed_modules = ref([]);
const modules = ref([]);
const student_role = ref(false);

onBeforeMount(async () => {
  student_role.value = await $filters.Auth.student_role();
});

onMounted(async () => {
  await getFormation();
});

const getFormation = async () => {
  try {
    const response = await axios.get(
      Laravel.urls.formations_show.replace(":slug", route.params.slug)
    );
    data.value = response.data;
    formation.value = response.data.formation;
    purchased_formation.value = response.data.purchased_formation;
    continue_formation.value = response.data.continue_formation;
    completed_modules.value = response.data.completed_modules;
    modules.value = response.data.modules;
  } catch (error) {
    // console.log(error);
  }
};
// formation = response.data.formation;
// purchased_formation = response.data.purchased_formation;
// formation_rating = response.data.formation_rating;
// completed_modules = response.data.completed_modules;
// total_ratings = response.data.total_ratings;
// is_reviewed = response.data.is_reviewed;
// review = response.data.review;
// modules = response.data.modules;
// continue_formation = response.data.continue_formation
// ? response.data.continue_formation
// : null;

// const ratings = $.map(data.formation.reviews, (review) =>
//   console.log(review.rating)
// );

$(document).on("change", 'input[name="stars"]', function () {
  $("#rating").val($(this).val());
});

if (data.review) {
  const rating = data.review.rating;
  $('input[value="' + rating + '"]').prop("checked", true);
  $("#rating").val(rating);
}

// const reviews_rating = () => {
//   axios.get(this.$laravel.urls.formations_rating).then((response) => {
//     console.log(response);
//   });
// }
// const rating_occurence_count = (arr, target) => {
//   let ratings = [];
//   let n = 0;
//   for (let item in arr) {
//     ratings[n] = arr["rating"];
//     n++;
//   }
//   let occurent = $.grep(ratings, function (elem) {
//     return elem === target;
//   });
//   return occurent;
// }
</script>


