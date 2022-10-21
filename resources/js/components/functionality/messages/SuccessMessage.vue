<template>
  <div class="message-container">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <div class="alert alert-success">
          <strong>Success!</strong> {{ message }}
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
</template>


<script setup>
const props = defineProps(["message"]);
</script>

