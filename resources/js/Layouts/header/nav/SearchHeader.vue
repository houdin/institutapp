<template>
    <button type="button" @click="modalOpener"
        class=" w-full flex items-center text-sm leading-6 text-gray-300 rounded-md ring-1 ring-gray-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-gray-500 bg-gray-700 dark:highlight-white/5 hover:bg-gray-600">
        <AppHeroIcon icon="MagnifyingGlassIcon" class="mr-3" size="w-5 h-5" />
        Rechercher...
        <!-- <span class="ml-auto pl-3 flex-none text-xs font-semibold">⌘K</span> -->
    </button>
    <SearchModal v-if="modal.type === 'search'" :outside="true" />
    <!-- <Form v-slot="{ errors, values }" @submit.prevent="handleSubmit" id="searchForm" class="search_form">
    <div class="searchBox">
      <Field as="input" type="text" name="search" rules="required" class="searchInput search-field" v-model="search"
        placeholder="Rechercher…" v-on:keyup="toggleResults" v-on:keyup.esc="close" autocomplete="off" />
      <a href="#" class="header-search-trigger searchButton">
        <span>
          <i class="fas fa-search"></i>
        </span>
      </a>
    </div>
    <div class="search-results" v-show="showResults">
      <ul>
        <li class="p-0 mt-2" v-for="(product, index) in searchResults" :key="index">
          <router-link class="p-0 text-lowercase" :to="{ name:'products.show', params: { slug: product.slug}}">
            <img v-if="product.image_id" :src="product.image_id" />
            <p class="p-0 ps-2">
              <strong>{{ product.title }}</strong>
              <span>{{ product.category_id }}</span>
            </p>
          </router-link>
        </li>
      </ul>
    </div>
  </Form> -->

    <!-- /.modal-mask -->
</template>


<script setup lang="ts">


//components = { Form, Field }

import Modal from '@/types/modalType';

const modal = inject<Modal>("modal");

const modalOpener = () => {
    // document.querySelector('#modals')?.classList.remove("hidden");
    modal.open('search')
}




</script>


