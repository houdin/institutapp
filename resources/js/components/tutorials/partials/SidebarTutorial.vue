<template>
  <div v-if="tutorial && Object.keys(tutorial).length > 0" class="side-bar">
    <div class="crs-side-bar-widget">

      <template v-if="!purchased">

        <h3>

          <span v-if="tutorial.free == 1"> {{ trans.get('labels.backend.formations.fields.free')}}</span>

          <template v-else>
            {{ trans.get('labels.frontend.formation.price') }}<span> {{appCurrency +' ' + tutorial.price}}</span>
          </template>

        </h3>
        <!-- Cart::session(auth()->user()->id)->get( $formation->id)) -->
        <button v-if="$filters.Auth.check() === true && $filters.Auth.hasrole('student') === true && $filters.Session.cartSession(tutorial.id, 'formation') === true" class="btn genius-btn btn-block text-center my-2 text-uppercase  btn-success text-white " type="submit">{{ trans.get('labels.frontend.formation.added_to_cart') }}
        </button>
        <template v-else-if="$filters.Auth.check() !== true">

          <a v-if="tutorial.free == 1" id="openLoginModal" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  " data-target="#myModal" href="#">{{ trans.get('labels.frontend.formation.get_now') }} <i class="fas fa-caret-right"></i></a>
          <template v-else>

            <a id="openLoginModal" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  " data-target="#myModal" href="#">{{ trans.get('labels.frontend.formation.buy_now') }} <i class="fas fa-caret-right"></i></a>

            <a id="openLoginModal" class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase " data-target="#myModal" href="#">{{ trans.get('labels.frontend.formation.add_to_cart') }} <i class="fa fa-shopping-bag"></i></a>
          </template>
        </template>
        <template v-else-if="$filters.Auth.check() === true && $filters.Auth.hasrole('student') === true">

          <Form v-if="tutorial.free == 1" id="card-getnow" @submit.prevent="onSubmit_card_getnow" v-slot="{ errors }" ref="card_getnow" enctype="multipart/form-data">
            <Field as="hidden" name="formation_id" :value="tutorial.id" />
            <Field as="hidden" name="amount" :value="(tutorial.free == 1) ? 0 : tutorial.price" />
            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  " href="#">{{ trans.get('labels.frontend.formation.get_now') }} <i class="fas fa-caret-right"></i></button>
          </Form>
          <template v-else>
            <Form id="card-checkout" @submit.prevent="onSubmit_card_checkout" v-slot="{ errors }" ref="card_checkout" enctype="multipart/form-data">

              <Field as="hidden" name="formation_id" :value="tutorial.id " />
              <Field as="hidden" name="amount" :value="(tutorial.free == 1) ? 0 : tutorial.price" />
              <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  " href="#">{{ trans.get('labels.frontend.formation.buy_now') }} <i class="fas fa-caret-right"></i></button>
            </Form>
            <Form id="card-addtocard" @submit.prevent="onSubmit_card_addtocard" v-slot="{ errors }" ref="card_addtocard" enctype="multipart/form-data">

              <Field as="hidden" name="formation_id" :value="tutorial.id" />
              <Field as="hidden" name="amount" :value="(tutorial.free == 1) ? 0 : tutorial.price" />
              <button type="submit" class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase ">
                {{ trans.get('labels.frontend.formation.add_to_cart') }} <i class="fa fa-shopping-bag"></i></button>
            </Form>
          </template>

        </template>

        <h6 v-else class="alert alert-danger"> {{ trans.get('labels.frontend.formation.buy_note')}}</h6>

      </template>

    </div>
    <div class="enrolled-student">
      <div class="comment-ratting float-left ul-li">
        <ul>
          <li v-for="n in tutorial.rating" :key="n"><i class="fas fa-star"></i></li>
        </ul>
      </div>
      <div class="student-number ">
        {{ tutorial.students_count }} {{ trans.get('labels.frontend.formation.enrolled') }}
      </div>
    </div>
    <div class="couse-feature ul-li-block">
      <ul>
        <li> {{ trans.get('labels.frontend.formation.chapters') }}
          <span> {{ tutorial.chapter_count }} </span>
        </li>

        <li class="d-inline-block w-100">{{ trans.get('labels.frontend.formation.category') }}
          <span class="text-right">
            <!-- <a href="{{route('formations.category',['category'=>$formation->category->slug])}}"
                                target="_blank">{{ formation.category.name}}</a> -->
            <router-link :to="{ name: 'tutorials.category', params: { category: tutorial.category.slug}}">{{ tutorial.category.name}}</router-link>
          </span>
        </li>
        <li> {{ trans.get('labels.frontend.formation.author') }} <span>

            <!-- <a href="{{route('teachers.show',['id'=>$teacher->id])}}" target="_blank">
                            {{$teacher->full_name}}@if($key < count($formation->teachers )), @endif
                        </a> -->
            <!-- <router-link v-for="( teacher, index) in formation.teachers" :key="index" :to="{ name: 'teachers.show', params: { id : teacher.id }}">
                            {{teacher.full_name + (index < Object.keys(formation.teachers).length ? ',' : '' )}}
                        </router-link> -->

          </span>
        </li>
      </ul>

    </div>
  </div>
</template>

<script>
import { Field, Form } from "vee-validate";
export default {
  props: ["tutorial", "purchased", "continueTutorial"],

  data() {
    return {
      appCurrency: Laravel.appCurrency,
    };
  },

  methods: {
    onSubmit_card_getnow() {
      const userdata = {
        email: this.user.email,
        password: this.user.password,
      };
      // if(isset($review)){
      //     $route = route('formations.review.update',['id'=>$review->id]);
      // }else{
      //     $route = route('formations.review',['formation'=>$formation->id]);
      // }
      this.$refs.card_getnow.validate().then((success) => {
        if (success) {
          axios
            .post(Laravel.urls.login, userdata)
            .then((response) => {
              if (response.errors) {
                if (response.errors.email) {
                  $("#email-error").html(response.errors.email[0]);
                }
                if (response.errors.password) {
                  $("#password-error").html(response.errors.password[0]);
                }

                // var captcha = "g-recaptcha-response";
                // if (response.errors[captcha]) {
                //     $('#login-captcha-error').html(response.errors[captcha][0]);
                // }
              }
              if (response.data.success) {
                this.$nextTick(() => {
                  this.$refs.loginform.reset();
                });
                if (response.data.redirect == "back") {
                  this.hideModal();
                } else if (response.data.redirect == "dashboard") {
                  window.location.replace("/user/dashboard");
                }
              }
            })
            .catch((error) => {
              console.log(error);
            });
          //   return;
        }

        // Resetting Values
        this.email = this.password = "";

        // Wait until the models are updated in the UI
        this.$nextTick(() => {
          this.$refs.loginform.reset();
        });
      });
    },
    onSubmit_card_checkout() {
      const userdata = {
        email: this.user.email,
        password: this.user.password,
      };
      // if(isset($review)){
      //     $route = route('formations.review.update',['id'=>$review->id]);
      // }else{
      //     $route = route('formations.review',['formation'=>$formation->id]);
      // }
      this.$refs.card_checkout.validate().then((success) => {
        if (success) {
          axios
            .post(Laravel.urls.login, userdata)
            .then((response) => {
              if (response.errors) {
                if (response.errors.email) {
                  $("#email-error").html(response.errors.email[0]);
                }
                if (response.errors.password) {
                  $("#password-error").html(response.errors.password[0]);
                }

                // var captcha = "g-recaptcha-response";
                // if (response.errors[captcha]) {
                //     $('#login-captcha-error').html(response.errors[captcha][0]);
                // }
              }
              if (response.data.success) {
                this.$nextTick(() => {
                  this.$refs.loginform.reset();
                });
                if (response.data.redirect == "back") {
                  this.hideModal();
                } else if (response.data.redirect == "dashboard") {
                  window.location.replace("/user/dashboard");
                }
              }
            })
            .catch((error) => {
              console.log(error);
            });
          //   return;
        }

        // Resetting Values
        this.email = this.password = "";

        // Wait until the models are updated in the UI
        this.$nextTick(() => {
          this.$refs.loginform.reset();
        });
      });
    },
    onSubmit_card_addtocard() {
      const userdata = {
        email: this.user.email,
        password: this.user.password,
      };
      // if(isset($review)){
      //     $route = route('formations.review.update',['id'=>$review->id]);
      // }else{
      //     $route = route('formations.review',['formation'=>$formation->id]);
      // }
      this.$refs.card_addtocard.validate().then((success) => {
        if (success) {
          axios
            .post(Laravel.urls.login, userdata)
            .then((response) => {
              if (response.errors) {
                if (response.errors.email) {
                  $("#email-error").html(response.errors.email[0]);
                }
                if (response.errors.password) {
                  $("#password-error").html(response.errors.password[0]);
                }

                // var captcha = "g-recaptcha-response";
                // if (response.errors[captcha]) {
                //     $('#login-captcha-error').html(response.errors[captcha][0]);
                // }
              }
              if (response.data.success) {
                this.$nextTick(() => {
                  this.$refs.loginform.reset();
                });
                if (response.data.redirect == "back") {
                  this.hideModal();
                } else if (response.data.redirect == "dashboard") {
                  window.location.replace("/user/dashboard");
                }
              }
            })
            .catch((error) => {
              console.log(error);
            });
          //   return;
        }

        // Resetting Values
        this.email = this.password = "";

        // Wait until the models are updated in the UI
        this.$nextTick(() => {
          this.$refs.loginform.reset();
        });
      });
    },
  },
};
</script>
