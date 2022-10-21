<template>
  <div class="tab-pane container active" id="register">

    <Form @submit="onSubmit" id="registerForm" :validation-schema="schema" class="contact_form">
      <!-- <form id="registerForm" class="contact_form"
                {{-- action="{{ route('frontend.auth.register.post')}}" --}}
                action="#"
                method="post">
                @csrf -->
      <div class="form-group">
        <div class="mb-2">
          <Field type="text" id="first_name" name="first_name" v-model="first_name" placeholder="Prénoms" maxlength="191" class="form-control mb-0" />
          <ErrorMessage name="first_name" v-slot="{ message }">
            <span class="text-danger special-danger" id="first-name-error">
              {{ message }}
            </span>
          </ErrorMessage>
        </div>
      </div>
      <div class="form-group">
        <div class="mb-2">
          <Field type="text" name="last_name" v-model="last_name" id="last_name" placeholder="Nom" maxlength="191" class="form-control mb-0" />
          <ErrorMessage name="last_name" v-slot="{ message }">
            <span class="text-danger special-danger" id="last-name-error">
              {{ message }}
            </span>
          </ErrorMessage>
        </div>
      </div>
      <div class="form-group">
        <div class="mb-2">
          <Field type="email" name="email" v-model="email" id="email" placeholder="Adresse électronique" maxlength="191" class="form-control mb-0" />
          <ErrorMessage name="email" v-slot="{ message }">
            <span class="text-danger special-danger" id="email-error">
              {{ message }}
            </span>
          </ErrorMessage>
        </div>
      </div>
      <div class="form-group">
        <div class="mb-2">
          <Field type="password" name="password" v-model="password" id="password" placeholder="Mot de passe" class="form-control mb-0" />
          <ErrorMessage name="password" v-slot="{ message }">
            <span class="text-danger special-danger" id="password-error">
              {{ message }}
            </span>
          </ErrorMessage>
        </div>
      </div>
      <div class="form-group">
        <div class="mb-2">
          <Field type="password" name="password_confirmation" v-model="password_confirmation" id="password_confirmation" placeholder="Confirmation mot de passe" class="form-control mb-0" />
          <ErrorMessage name="password_confirmation" v-slot="{ message }">
            <span class="text-danger special-danger" id="confirm-password-error">
              {{ message }}
            </span>
          </ErrorMessage>
        </div>
      </div>

      <div class="mt-3 text-center">
        <!-- <VueRecaptcha :sitekey="sitekey" :loadRecaptchaScript="true" @verify="validate"/> -->
        <!-- <div id="totnont" ref="register_captcha">tontotn <input type="text"></div> -->
        <!-- <vue-recaptcha :sitekey="$laravel.app.recaptcha.sitekey"></vue-recaptcha> -->
        <span class="text-danger special-danger" id="captcha-error"></span>

      </div>
      <vue-recaptcha theme="light" size="normal" :tabindex="0" @widgetId="recaptchaWidget = $event" @verify="callbackVerify($event)" @expired="callbackExpired()" @fail="callbackFail()" />
      <input type="hidden" name="captcha_status" id="captcha_status" value="true">
      <!-- @if(config('access.captcha.registration'))
                <div class="mt-3 text-center">
                    {!! Captcha::display() !!}
                    {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                    <span id="captcha-error" class="special-danger"></span>

                </div>
            @endif -->
      <div class="nws-button text-center white text-capitalize">
        <button id="registerButton" type="submit" value="Submit">S'Inscrire maintenant</button>
      </div>

      <!-- <div class="nws-button text-center white text-capitalize">
                <button id="registerButton" type="submit"
                        value="Submit">$trans.get('labels.frontend.modal.register_now')</button>
            </div> -->

      <a href="/teacher/register" class="fgo-register float-left special mt-2 mb-3 w-100">
        S'inscrire en tant que Formateur? Cliquez ici
      </a>
      <!-- <router-link :to="{name:'teacher.register'}" class="float-left special mt-2 mb-3 w-100">
            S'inscrire en tant que professeur? Cliquez ici
        </router-link> -->
      <!-- <a href="https://fxinstitut.test/teacher/register"
            class="fgo-register float-left special mt-2 mb-3 w-100">
            S'inscrire en tant que professeur? Cliquez ici </a> -->
    </Form>

    <div class="">
      <p style="font-size: 13px; line-height: 1.6">
        Ce formulaire utilise <a class="special" href="https://www.google.com/recaptcha/intro/android.html">reCAPTCHA</a>
        afin de lutter contre le SPAM. L'utilisation de cette fonctionnalité est soumise aux
        <a class="special" href="https://www.google.com/intl/fr/policies/privacy/">Règles de confidentialité</a>
        et aux <a class="special" href="https://www.google.com/intl/fr/policies/terms/">Conditions d'utilisation</a> de Google.
      </p>
    </div>
  </div>

</template>

<script setup>
import { ref } from "@vue/reactivity";
import { nextTick, watch } from "@vue/runtime-core";
import { Form, Field, ErrorMessage, useForm, useField } from "vee-validate";
import { useRoute } from "vue-router";
import { object as objectYup } from "yup";
import { string as stringYup } from "yup";
import { ref as refYup } from "yup";
import { VueRecaptcha, useRecaptcha } from "vue3-recaptcha-v2";

const recaptchaWidget = ref(null);

const callbackVerify = (response) => {
  console.log(response);
};
const callbackExpired = () => {
  console.log("expired!");
};
const callbackFail = () => {
  console.log("fail");
};

const remember = ref(false);

const route = useRoute();
const success = ref("");
const error_email = ref("");
const error_password = ref("");
const sitekey = process.env.RECAPTCHA_PUBLIC_KEY;

const teacher_register = "";
const urls = Laravel.urls;

const emit = defineEmits(["hideModal"]);

const schema = objectYup({
  first_name: stringYup()
    .required("Veuillez entrer votre prénom")
    .matches(
      /^[aA-zZ\s]+$/,
      "Seuls les alphabets sont autorisés pour ce champ"
    ),
  last_name: stringYup()
    .required("Veuillez entrer votre nom")
    .matches(
      /^[aA-zZ\s]+$/,
      "Seuls les alphabets sont autorisés pour ce champ "
    ),
  email: stringYup()
    .required("Veuillez entrer une adresse email")
    .email("Veuillez entrer une adresse email valide"),
  password: stringYup()
    .required("Veuiller entrer votre mot de passe")
    .matches(
      /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/,
      "Au moins 8 caractères, une majuscule, un chiffre et un caractère spécial"
    ),
  password_confirmation: stringYup().oneOf(
    [refYup("password"), null],
    "Les mots de passe doivent correspondre"
  ),
});

// Create a form context with the validation schema
const { handleSubmit, errors, isSubmitting } = useForm();

// No need to define rules for fields
const { value: first_name } = useField("first_name");
const { value: last_name } = useField("last_name");
const { value: email } = useField("email");
const { value: password } = useField("password");
const { value: password_confirmation } = useField("password_confirmation");

const hideModal = () => {
  emit("hideModal", "JE SUIS EN PLEIN TEST");
};

const onSubmit = handleSubmit(async (values, { resetForm }) => {
  //   const userdata = {
  //     email: email.value,
  //     password: password.value,
  //   };
  try {
    console.log("Up axios Await");
    const response = await axios.post(Laravel.urls.register, values);
    console.log(response.data);
    if (response.data.success) {
      emit("hideModal", response.data.verify_text);
      //   Event.$emit("update-user-message", response.data.verify_text);
      //   resetForm();
      //   if (response.data.redirect == "back") {
      //     console.log("EMITTER");
      //     emit("hideModal");
      //   } else if (response.data.redirect == "dashboard") {
      //     window.location.replace("/user/dashboard");
      //   }
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
