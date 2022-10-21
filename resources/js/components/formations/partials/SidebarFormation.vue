<template>
  <div class="side-bar">
    <div class="crs-side-bar-widget">

      <template v-if="!purchased || isPurchased === true">

        <h3>

          <span v-if="formation.free == 1"> {{ trans.get('labels.backend.formations.fields.free')}}</span>

          <template v-else>
            {{ trans.get('labels.frontend.formation.price') }}<span> {{appCurrency +' ' + formation.price}}</span>
          </template>

        </h3>
        <!-- Cart::session(auth()->user()->id)->get( $formation->id)) -->
        <button v-if="user_check === true && student_role === true && session_formation === true" class="btn genius-btn btn-block text-center my-2 text-uppercase  btn-success text-white " type="submit">{{ trans.get('labels.frontend.formation.added_to_cart') }}
        </button>
        <template v-else-if="user_check !== true">
          <router-link v-if="formation.free == 1" :to="{name:'login'}" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  ">{{ trans.get('labels.frontend.formation.get_now') }} <i class="fas fa-caret-right"></i></router-link>

          <template v-else>

            <router-link :to="{name:'login'}" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  ">{{ trans.get('labels.frontend.formation.buy_now') }} <i class="fas fa-caret-right"></i></router-link>
            <router-link :to="{name:'login'}" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  ">{{ trans.get('labels.frontend.formation.add_to_cart') }} <i class="fa fa-shopping-bag"></i></router-link>

          </template>
        </template>
        <template v-else-if="user_check === true && student_role === true">
          <get-now-cart v-if="formation.free == 1" :product-id="formation.id" type="formation" cart-text @getnow="formations_purchased"></get-now-cart>
          <!-- <Form v-if="formation.free == 1" id="card-getnow" @submit.prevent="onSubmit_card_getnow" v-slot="{ errors }" ref="card_getnow" enctype="multipart/form-data">
            <Field as="hidden" name="formation_id" :value="formation.id" />
            <Field as="hidden" name="amount" :value="(formation.free == 1) ? 0 : formation.price" />
            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  " href="#">{{ trans.get('labels.frontend.formation.get_now') }} <i class="fas fa-caret-right"></i></button>
          </Form> -->
          <template v-else>
            <!-- <Form id="card-checkout" @submit.prevent="onSubmit_card_checkout" v-slot="{ errors }" ref="card_checkout" enctype="multipart/form-data">

              <Field as="hidden" name="formation_id" :value="formation.id " />
              <Field as="hidden" name="amount" :value="(formation.free == 1) ? 0 : formation.price" />
              <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  " href="#">{{ trans.get('labels.frontend.formation.buy_now') }} <i class="fas fa-caret-right"></i></button>
            </Form> -->
            <add-cart-icon :product-id="formation.id" type="formation" cart-text></add-cart-icon>
          </template>

        </template>

        <h6 v-else class="alert alert-danger"> {{ trans.get('labels.frontend.formation.buy_note')}}</h6>

      </template>
      <template v-else>

        <router-link v-if="continueFormation !== null" :to="{ name: 'modules.show', params: { formation_id: formation.id, slug: continueFormation.model.slug}}" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  ">{{ trans.get('labels.frontend.formation.continue_formation') }}

          <i class="fa fa-arow-right"></i>
        </router-link>
      </template>

    </div>
    <div class="enrolled-student">
      <div class="comment-ratting float-left ul-li">
        <ul>
          <li v-for="n in formation.rating" :key="n"><i class="fas fa-star"></i></li>
        </ul>
      </div>
      <div class="student-number ">
        {{ formation.students_count }} {{ trans.get('labels.frontend.formation.enrolled') }}
      </div>
    </div>
    <div class="crs-feature ul-li-block">
      <ul>
        <li> {{ trans.get('labels.frontend.formation.chapters') }}
          <span> {{ formation.chapter_count }} </span>
        </li>

        <li class="d-inline-block w-100">{{ trans.get('labels.frontend.formation.category') }}
          <span class="text-right">
            <!-- <a href="{{route('formations.category',['category'=>$formation->category->slug])}}"
                                target="_blank">{{ formation.category.name}}</a> -->
            <router-link :to="{ name: 'formations.category', params: { category: formation.category.slug}}">{{ formation.category.name}}</router-link>
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

<script setup>
import { computed, ref } from "@vue/reactivity";
import { inject, nextTick, onBeforeMount } from "@vue/runtime-core";
import { Field, Form } from "vee-validate";
import { useStore } from "vuex";

const props = defineProps(["formation", "purchased", "continueFormation"]);
const $filters = inject("$filters");

const store = useStore();

const appCurrency = Laravel.appCurrency;

const isPurchased = ref(false);

const user_check = ref(false);
const admin_role = ref(false);
const student_role = ref(false);
const session_formation = ref(false);

onBeforeMount(async () => {
  user_check.value = await $filters.Auth.check();
  student_role.value = await $filters.Auth.student_role();
  admin_role.value = await $filters.Auth.admin_role();
  session_formation.value = await $filters.Session.cartSession(
    props.formation.id,
    "formation"
  );
});

async function formations_purchased() {
  try {
    const res = await axios.get(
      Laravel.urls.formations_purchased.replace(
        ":formation_id",
        props.formation.id
      )
    );
    if (res.data.purchased) {
      alert("REFRESH !!!!");
      isPurchased.value = true;
    }
    return res.data.purchased;
  } catch (error) {}
}
</script>
