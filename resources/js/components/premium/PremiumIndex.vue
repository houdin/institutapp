<template>

  <h1 class="text-center pricing">Bootstrap pricing table</h1> <br>
  <div class="mb-5 text-center">
    <h3 class=" mt-4">Pricing plans</h3>
    <div class="fluid-paragraph mt-3">
      <p class="lead lh-180">We'll make sure we build everything you need from now on</p>
    </div>
  </div>
  <div v-if="premiums[0]" class="row text-center align-items-start">

    <div v-for="(item, index) in premiums" :key="index" class="col-lg-4 mb-5 mb-lg-0">
      <div class="bg-gray-6 p-5 rounded-lg shadow border border-base-5">
        <h1 class="h6 text-uppercase font-weight-bold mb-4">{{ item.name }}</h1>
        <h2 class="h1 font-weight-bold">${{ item.price }}<span class="text-small font-weight-normal ms-2">/ month</span></h2>
        <div class="custom-separator my-4 mx-auto bg-base-2"></div>
        <ul class="list-unstyled my-5 text-small text-left">

          <li class="mb-3" v-for="(line, index) in item.premium_list" :key="index"> <i class="fa fa-check me-2 text-primary"></i>{{ line }}</li>

        </ul> <a href="#" class="btn bg-base-2 btn-block color-gray-8 p-2 shadow rounded-pill">Subscribe</a>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  data() {
    return {
      premiums: [],
    };
  },
  created() {
    this.getPremiums();
  },
  mounted() {},
  methods: {
    getPremiums() {
      axios
        .get(this.$laravel.urls.premium_index)
        .then((response) => {
          this.premiums = response.data.premiums;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
