<template>
  <div id="search-formation" class="search-formation-section">

    <div class="search-formation mb30 position-relative ">
      <ValidationObserver>

        <!-- <form action="{{route('search')}}" method="get"> -->
        <form action="" method="get">

          <div class="input-group search-group">
            <input class="formation" name="q" type="text" placeholder="{{ trans.get('labels.frontend.home.search_formation_placeholder') }}">
            <select name="category" class="select form-control">
              <!-- @if(count($categories) > 0 ) -->
              <template v-if="categories.length > 0">

                <option value="">{{ trans.get('labels.frontend.formation.select_category') }}</option>

                <option v-for="item in categories" :key="item.id" :value="item.id">{{item.name}}</option>

              </template>
              <option v-else> {{ trans.get('labels.frontend.home.no_data_available') }}</option>

            </select>
            <div class="nws-button position-relative text-center  gradient-bg text-capitalize">
              <button type="submit" value="Submit">{{ trans.get('labels.frontend.home.search_formation') }}</button>
            </div>
          </div>
        </form>
      </ValidationObserver>
    </div>

  </div>
</template>

<script>
export default {
  props: [],

  data() {
    return {
      categories: {},
    };
  },

  created() {},
  mounted() {},
  methods: {
    getSearch() {
      axios.get("/search").then((response) => {
        console.log(response.data);
      });
    },
  },
};
</script>
