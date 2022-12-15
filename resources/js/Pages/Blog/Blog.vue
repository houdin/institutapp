<template>
  <router-view v-slot="{ Component, route}">
    <transition :enter-active-class="route.meta.enterClass" :leave-active-class="route.meta.leaveClass">

      <component :is="Component"></component>

    </transition>
  </router-view>
</template>

<script setup lang="ts">
</script>
