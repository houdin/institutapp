<template>
  <div class="tab-pane container active" id="login">

    <span v-if="error_email" class="error-response special-danger">{{error_email}}</span>
    <span v-if="error_password" class="error-response special-danger">{{error_password}}</span>
    <!-- <span class="success-response text-success">{{(session()->get('flash_success'))}}</span> -->
    <span v-if="success" class="success-response text-success">{{success}}</span>
    <!-- LOGIN -->
    <!-- route('frontend.auth.login') -->

    <!-- route('frontend.auth.login') -->

    <Form @submit="onSubmit" :validation-schema="schema" id="loginForm" class="contact_form">

      <div class="form-group">

        <div class="mb-2">
          <Field id="email" type="email" name="email" class="form-control mb-0 ps-5" placeholder="Adresse E-mail" maxlength="191" v-model="email"></Field>
          <ErrorMessage name="email" v-slot="{ message }">
            <span class="text-danger special-danger" id="email-error">
              {{ message }}
            </span>
          </ErrorMessage>
        </div>
      </div>
      <div class="form-group">
        <div class="mb-2">
          <Field id="password" type="password" name="password" placeholder="Mot de passe" class="form-control mb-0 ps-5" v-model="password"></Field>
          <ErrorMessage name="password" v-slot="{ message }">
            <span class="text-danger special-danger" id="password-error">
              {{ message  }}
            </span>
          </ErrorMessage>
        </div>
      </div>

      <div class="form-group">
        <div class="mb-2 text-left">
          <Field type="checkbox" name="remember_me" class="float-left me-2" style="width:unset; height:22px" v-model="remember"></Field>
          <span>Se souvenir</span>
        </div>
      </div>

      <!-- @if(config('access.captcha.registration'))
                <div class="contact-info mb-2 text-center">
                    {!! Captcha::display() !!}
                    {{ html()->hidden('captcha_status', 'true') }}
                    <span id="login-captcha-error" class="special-danger"></span>

                </div>
            @endif -->
      <div class="nws-button text-center white text-capitalize">
        <button type="submit" :disabled="isSubmitting">Se Connecter</button>
      </div>
      <!-- {{ trans.get('labels.frontend.passwords.forgot_password') }} -->
      <!-- route('frontend.auth.password.reset') -->
      <router-link :to="{ name :'password.reset'}" class="special p-0 d-block text-center my-3">Avez-vous oublié votre mot de passe&nbsp;?</router-link>
      <!-- <a href="https://fxinstitut.test/password/reset" class="special p-0 d-block text-center my-3">Avez-vous oublié votre mot de passe&nbsp;?</a> -->

    </Form>
    <!-- <div id="socialLinks" class="text-center">
        </div> -->
    <div id="socialLinks" class="text-center">
      <div class="text-center mb-0">
        <span>Réseaux Sociaux</span>
      </div>
      <a href="https://fxinstitut.test/login/facebook" class="btn m-1 my-3" style="position:relative; background: #3B5499; color: #ffffff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
        <i class="fab fa-facebook" style="position:absolute; left:15px; margin-top:3px"></i>
        <span>Se connecter avec Facebook</span>
      </a>
      <a href="https://fxinstitut.test/login/google" class="btn m-1 my-3" style="position:relative; background: #dd4b39; color: #ffffff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
        <i class="fab fa-google" style="position:absolute; left:15px; margin-top:3px"></i>
        <span>Se connecter avec Google</span>
      </a>
    </div>

  </div>

</template>



<script setup>
import { ref } from "@vue/reactivity";
import { nextTick, watch } from "@vue/runtime-core";
import { Form, Field, ErrorMessage, useForm, useField } from "vee-validate";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import { object as objectYup } from "yup";
import { string as stringYup } from "yup";

const store = useStore();
const remember = ref(false);

const route = useRoute();
const success = ref("");
const error_email = ref("");
const error_password = ref("");

const emit = defineEmits(["hideModal"]);

const schema = objectYup({
  email: stringYup()
    .required("Veuillez entrer une adresse Email")
    .email("Veuillez entrer une adresse Email valide"),
  password: stringYup().required("Veuillez entrer votre mot de passe"),
});

// Create a form context with the validation schema
const { handleSubmit, errors, isSubmitting } = useForm();

// No need to define rules for fields
const { value: email } = useField("email");
const { value: password } = useField("password");

const onSubmit = handleSubmit(async (values, { resetForm }) => {
  //   const userdata = {
  //     email: email.value,
  //     password: password.value,
  //   };
  try {
    console.log("Up axios Await");
    const response = await axios.post(Laravel.urls.login, values);
    console.log(response.data);
    if (response.data.success) {
      store.dispatch("CurrentUser/getUser");
      //   resetForm();
      if (response.data.redirect == "back") {
        Event.$emit("checkUser", true);
        emit("hideModal");
      } else if (response.data.redirect == "dashboard") {
        window.location.replace("/user/dashboard");
      }
    }

    if (response.errors) {
      if (response.errors.email) {
        // setFieldError("email", response.errors.email);
        error_email.value = response.errors.email[0];
        // $("#email-error").html(response.errors.email[0]);
      }
      if (response.errors.password) {
        // setFieldError("password", response.errors.email);
        // $("#password-error").html(response.errors.password[0]);
        error_password.value = response.errors.password[0];
      }

      //   const captcha = "g-recaptcha-response";
      //   if (response.errors[captcha]) {
      //     $("#login-captcha-error").html(response.errors[captcha][0]);
      //   }
      // setErrors(response.errors);
    }
  } catch (error) {
    console.log(error);
  }

  // Resetting Values
  // email.value = password.value = "";

  //   Wait until the models are updated in the UI
  //   resetForm();
});
</script>



