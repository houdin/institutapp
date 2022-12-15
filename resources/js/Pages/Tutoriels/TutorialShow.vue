<template>

  <!-- Start of formation details section
        ============================================= -->

  <div v-if="Object.keys(data).length > 0" class="row">
    <div class="col">
      <div v-if="Objec  t.keys(data.tutorial.image).length > 0" class="crs-single-pic mb30"
        :style="'background-image: url(' + data.tutorial.image.url +')'">

        <!-- <img v-if="formation.image" :src="formation.image.url" width="100%"
                                    alt=""> -->

      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
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
              <router-link v-if="data.tutorial.slug"
                :to="{ name: 'f  ormations.show', params: { slug:data.tutorial.slug }}"><b>{{data.tutorial.title}}</b>
              </router-link>

              <span v-if="  data.tutorial.trending == 1" class="trend-badge text-uppercase ">
                {{ trans.get('labels.frontend.badges.trending')}}<i class="fas fa-bolt"></i></span>

            </h3>
          </div>
          <div class="crs-details-content">
            <p v-if="data.tutorial.description">
              {{ data.tutorial.description }}
            </p>
          </div>

          <media-tutorial :media-video="dat  a.tutorial.media_video"></media-tutorial>

        </div>
      </div>

      <!-- /market guide -->

      <div v-if="Objec  t.keys(data.purchased_tut  orial).length > 0" class="crs-comment">
        <purchased-tutorial :purchased="data.purchased_tutorial"></purchased-tutorial>
      </div>

    </div>

    <div class="col-md-4">
      <sidebar-tutorial :formation="data.tutorial" :purchased="data.purchased_tutorial"
        :continue-tutorial="data.continue_tutorial"></sidebar-tutorial>
    </div>
  </div>

  <!-- End of formation details section
        ============================================= -->

</template>

<script setup lang="ts">
import Plyr from "plyr";
// import polyfilled from 'https://cdn.plyr.io/3.5.3/plyr.polyfilled.js'
import format from "date-fns/format";
import formatDistance from "date-fns/formatDistance";
import { useRoute } from "vue-router";
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";

const player = new Plyr("#player");

const route = useRoute();

const data = ref({});

const getTutorial = async () => {
  try {
    const response = await axios.get(
      Laravel.urls.tutorials_show.replace(":slug", route.params.slug)
    );
    data.value = response.data;
  } catch (error) {
    console.log(error);
  }
};

onMounted(async () => {
  await getTutorial();
});
// formation = response.data.tutorial;
// purchased_formation = response.data.purchased_formation;
// formation_rating = response.data.tutorial_rating;
// completed_modules = response.data.completed_modules;
// total_ratings = response.data.total_ratings;
// is_reviewed = response.data.is_reviewed;
// review = response.data.review;
// modules = response.data.modules;
// continue_formation = response.data.continue_formation
// ? response.data.continue_formation
// : null;

// const ratings = $.map(data.tutorial.reviews, (review) =>
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


