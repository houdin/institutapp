<template>
  <div id="mobile-menu" class="mobile-menu">

    <ul v-if="$laravel.app.custom_menus">

      <!-- @foreach($custom_menus as $key => $value) -->
      <li v-for="(value, index) in $laravel.app.custom_menus" :key="index" class="">

        <template v-if="typeof value == 'object'">
          <!-- <a href="#!" :class="{'nav-link' : true, 'router-link-active router-link-exact-active' : isActive(index, $route.path)  }">{{index}}</a> -->
          <ul class="">

            <nav-dropdown v-for="(item, index2 ) in value" :key="index2" :item="item" :label="index2"
              :home="$laravel.urls.index">

            </nav-dropdown>

          </ul>
        </template>
        <template v-else>
          <router-link :to="'/' + value" :id="'menu-' + value" class="nav-link">{{index}}</router-link>
        </template>

      </li>

      <!-- @endforeach -->

    </ul>

  </div>
</template>

<script setup lang="ts">
</script>
