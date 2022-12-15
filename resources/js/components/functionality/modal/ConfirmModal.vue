<template>

  <app-modal animation="bounceIn">
    <template v-slot:title>
      <slot name="title"></slot>
    </template>
    <template v-slot:body>
      <slot name="body"></slot>
    </template>
    <template v-slot:footer>
      <div class="row">
        <div class="col-xs-3 col-xs-offset-3">
          <button class="btn btn-primary" @click="confirm">OK</button>
        </div>
        <div class="col-xs-3 col-xs-offset-1">
          <button class="btn btn-danger" @click="cancel">Cancel</button>
        </div>
      </div>
    </template>

  </app-modal>

</template>

<script setup lang="ts">
const emit = defineEmits(["confirm", "cancel"]);

const confirm = (e) => {
  e.preventDefault();
  Event.$emit("bs:hide:modal", true);
  emit("confirm");
};

const cancel = (e) => {
  //   e.preventDefault();
  e.preventDefault();
  Event.$emit("bs:hide:modal", true);
  emit("cancel");
};
</script>

