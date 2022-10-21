<template>
  <div></div>
  <!-- <VueRecaptcha :sitekey="sitekey" :loadRecaptchaScript="true" @verify="validate">

     </VueRecaptcha> -->
</template>


 <script>
// import VueRecaptcha from "vue-recaptcha";
// import Validation from '../recaptcha/repcatchaValidate'
export default {
  //   components: {VueRecaptcha},
  data() {
    return {
      sitekey: this.$laravel.app.recaptcha.sitekey,
    };
  },
  methods: {
    // validate(response) {
    //   Validation.validate({ Response: response })
    //     .then((result) => {
    //       this.$emit("validate", result.objectResult.success);
    //     })
    //     .catch((error) => console.log(error));
    // },
  },
};
</script>
