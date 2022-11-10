<template>
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      Categories<span class="caret"></span>
    </a>

    <ul class="dropdown-menu" id="navbar-category">
      <li v-for="(category, index) in categories" :key="index">
        <a :href="$laravel.urls.shopping_search_product_category + '/' + encodeURIComponent(category)">{{
          category
        }}</a>
      </li>
    </ul>
  </li>
</template>


<script>
export default {
  props: ["categories"],

  data() {
    return {};
  },
};
</script>
