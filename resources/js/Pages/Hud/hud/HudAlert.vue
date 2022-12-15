<template>
  <div v-if="objectData.length == 0">
    <p class="alert alert-warning">
      {{ message }}
    </p>
  </div>
</template>
<script>
export default {
  props: ["objectData", "message"],
};
</script>
