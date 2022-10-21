<template>
  <li class="nav-item me-4">
    <a href="#" @click="show">
      <i class="fa fa-search" aria-hidden="true"></i>
    </a>
  </li>
</template>

<script>
export default {
  methods: {
    /**
     * shows the search screen
     *
     * @return void
     */
    show() {
      Event.$emit("show-search-screen");
    },
  },
};
</script>
