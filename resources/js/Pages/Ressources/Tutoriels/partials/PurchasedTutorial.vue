<template>
  <div class="blog-comment-area ul-li about-teacher-2">

    <template v-if="purchased">

      <div v-if="review || (is_reviewed == false)" class="reply-comment-box">
        <div class="review-option">
          <div class="section-title-2  headline text-left float-left">
            <h2>{{ trans.get('labels.frontend.formation.add_reviews') }}</h2>
          </div>
          <div class="review-stars-item float-right mt15">
            <span>{{ trans.get('labels.frontend.formation.your_rating') }}: </span>
            <div class="rating">
              <label>
                <input type="radio" name="stars" value="1" />
                <span class="icon"><i class="fas fa-star"></i></span>
              </label>
              <label>
                <input type="radio" name="stars" value="2" />
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
              </label>
              <label>
                <input type="radio" name="stars" value="3" />
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
              </label>
              <label>
                <input type="radio" name="stars" value="4" />
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
              </label>
              <label>
                <input type="radio" name="stars" value="5" />
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
                <span class="icon"><i class="fas fa-star"></i></span>
              </label>
            </div>
          </div>
        </div>
        <div class="teacher-faq-form">

          <Form @submit.prevent="onSubmit" v-slot="{ errors }" ref="reviewform" id="reviewForm" enctype="multipart/form-data" data-lead="Residential">

            <input type="hidden" name="rating" id="rating">

            <label for="review" v-html="trans.get('labels.frontend.formation.message')"></label>
            <Field as="textarea" name="review" v-model="review.content" ules="required" class="mb-2" id="review" rows="2" cols="20" />
            <!-- <span class="help-block text-danger">{{ errors->first('review', ':message') }}</span> -->
            <span class="text-danger special-danger" id="email-error" v-show="errors.review">
              {{ errors.review }}
            </span>
            <div class="nws-button text-center  gradient-bg text-uppercase">
              <button type="submit" value="Submit">{{ trans.get('labels.frontend.formation.add_review_now') }}
              </button>
            </div>

          </Form>
        </div>
      </div>
    </template>

  </div>
</template>

<script>
import { Form, Field } from "vee-validate";
export default {
  props: ["purchased"],
  data() {
    return {};
  },
  methods: {
    onSubmit(values) {
      const userdata = {
        email: this.user.email,
        password: this.user.password,
      };

      var route_path = "";
      var review_data = "";
      if (this.review) {
        route_path = Laravel.urls.formation_review_update.replace(
          "/edit",
          "/" + this.review.id + "/edit"
        );
      } else {
        route_path = Laravel.urls.formation_review.replace(
          "/review",
          "/" + this.formation.id + "/review"
        );
      }
      axios
        .post(route_path, this.review)
        .then((response) => {
          if (response.errors) {
            if (response.errors.email) {
              $("#email-error").html(response.errors.email[0]);
            }
          }
          if (response.data.success) {
            this.$nextTick(() => {
              this.$refs.reviewform.reset();
            });
            if (response.data.redirect == "back") {
            } else if (response.data.redirect == "dashboard") {
              window.location.replace("/user/dashboard");
            }
          }
        })
        .catch((error) => {
          console.log(error);
        });

      //   this.$refs.reviewform.validate().then((success) => {
      //     if (success) {

      //       //   return;
      //     }

      // Resetting Values
      this.review = {};

      // Wait until the models are updated in the UI
      this.$nextTick(() => {
        this.$refs.reviewform.reset();
      });
    },
  },
};
</script>
