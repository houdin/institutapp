<template >

  <div id="faq" class="faq-section">

    <div class="section-title mb45 headline text-center ">
      <span class="subtitle text-uppercase">{{$laravel.app.name}} {{trans.get('labels.frontend.layouts.partials.faq')}}</span>
      <h2><span v-html="trans.get('labels.frontend.layouts.partials.faq_full')"></span></h2>
    </div>
    <!-- ////////// -->

    <div>
    </div>

    <!-- //// -->

    <div v-if="faqs" class="faq-tab">
      <div class="faq-tab-ques ul-li">
        <div class="tab-button text-center mb65 ">
          <ul class="nav nav-tabs justify-content-center border-base-5" id="myTab" role="tablist">

            <li class="nav-item " v-for="(faq, index) in faqs" :key="faq.id">
              <a :class="'nav-link color-gray-6 bg-base-2 ' + (index == 0 ? 'active': '')" :id="faq.name + '-tab'" data-toggle="tab" :href="'#' + faq.name" role="tab" :aria-controls="faq.name" aria-selected="true">{{faq.name}}</a>
            </li>

          </ul>
        </div>
        <div class="tab-content tab-container" id="myTabContent">
          <!-- tab -->
          <div v-for="(faq, index) in faqs" :key="faq.id" :id="faq.name" :class="'tab-pane fade pt35 ' + (index == 0 ? 'show active': '')" role="tabpanel" :aria-labelledby="faq.name + '-tab'">
            <div class="row">

              <div class="col-md-6" v-for="item in faq.faqs.slice(0, 4)" :key="item.id">
                <div class="ques-ans mb45 headline">
                  <h3 class="color-base-2"> {{item.question}}</h3>
                  <p class="color-gray-2">{{item.answer}}</p>
                </div>
              </div>

            </div>
          </div>
          <!-- #tab -->

        </div>
        <div :class="'view-all-btn  text-white' ">

          <router-link :to="{name:'faqs'}" class="color-base-2">
            {{trans.get('labels.frontend.layouts.partials.more_faqs') }}
            <i class="fas fa-chevron-circle-right"></i>
          </router-link>

        </div>
      </div>
    </div>

    <h4 v-else>{{trans.get('labels.general.no_data_available')}}</h4>

  </div>

</template>

<script setup>
const { ref } = require("@vue/reactivity");
const { onMounted, inject } = require("@vue/runtime-core");

const faqs = ref({});

(async function getFaqs() {
  try {
    let response = await axios.get(Laravel.urls.home_faqs);
    faqs.value = response.data.faqs;
  } catch (err) {
    console.log(err);
  }
})();

onMounted(() => {});
</script>


