<template >
  <div id="premium">

    <div class="section-title mb20 headline text-left ">

      <h2 v-html="trans.get('labels.frontend.layouts.partials.view_all_news')"></h2>
    </div>
    <div v-if="homeData.premiums" class="row">

      <div v-for="item in homeData.premiums" :key="item.id" class="col-md-4 col-lg-4 mb-5 mb-lg-0">
        <div class="bg-gray-6 p-5 rounded-lg shadow border border-base-5">
          <h1 class="h6 text-uppercase font-weight-bold mb-4">{{ item.name }}</h1>
          <h2 class="h1 font-weight-bold">${{ item.price }}<span class="text-small font-weight-normal ms-2">/ month</span></h2>
          <div class="custom-separator my-4 mx-auto bg-base-2"></div>
          <ul class="list-unstyled my-3 text-small text-left" style="height: 180px;">

            <li v-for="(line, index) in premiumList(item.content)" :key="index" class="mb-3">
              <i class="fa fa-check me-2 text-primary"></i>{{ line }}
            </li>

          </ul>
          <a href="#" class="btn bg-base-2 btn-block color-gray-8 p-2 shadow rounded-pill">
            {{trans.get('labels.frontend.layouts.partials.view_all_news')}}
            <!-- {{--Voir le detail...--}} -->
          </a>
        </div>
      </div>

    </div>

  </div>

</template>

<script setup>
const { ref } = require("@vue/reactivity");
const { onMounted, inject } = require("@vue/runtime-core");

const homeData = inject("homeData");
const premiums = ref({});

onMounted(() => {});

const premiumList = (content) => {
  content = content.slice(0, -1);
  return content.split(".", 3);
};
</script>
