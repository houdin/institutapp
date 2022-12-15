<script setup lang="ts">



defineProps({
    canResetPassword: Boolean,
    status: String,
});
const modal = inject('modal');

// const modal = reactive({
//     container: null,
//     open: false,
//     switch: false,
//     type: '',
//     class: 'px-6 pb-4 sm:my-8 sm:w-full sm:max-w-lg sm:px-10',
//     data: {},
//     background: true
// })


const form = useForm({
    email: '',
    password: '',
    remember: false,
});



const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />

    <!--
  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
    <!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-50">
  <body class="h-full">
  ```
-->

</template>
