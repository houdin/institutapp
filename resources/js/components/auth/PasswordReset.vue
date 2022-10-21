<template>

  <div class="row justify-content-center align-items-center">
    <div class="col col-sm-6 align-self-center">
      <div class="card border-0">
        <div class="card-body">
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="list-inline list-style-none">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <!-- {{ html()->form('POST', route('password.request'))->class('form-horizontal')->open() }}
                        {{ html()->hidden('token', $token) }}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                    {{ html()->email('email')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                        ->required() }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    <button class="btn btn-info" type="submit">{{__('labels.frontend.passwords.reset_password_button')}}</button>
                                </div>
                            </div>
                        </div>
                        {{ html()->form()->close() }} -->
          <Form @submit="onSubmit" id="loginForm" v-slot="{ errors, values }" enctype="multipart/form-data" class="contact_form 'form-horizontal'">

            <div :class="{
              'form-group': true,
              'has-error': errors.email ? true : false,
            }">
              <div class="mb-2">
                <Field id="email" type="email" name="email" rules="required|email" class="form-control mb-0 ps-5" placeholder="Adresse E-mail" maxlength="191" v-model="email" />
                <span class="text-danger special-danger" id="email-error" v-show="errors.email">
                  {{ errors.email }}
                </span>
              </div>
            </div>
            <div :class="{
              'form-group': true,
              'has-error': errors.password ? true : false,
            }">
              <div class="mb-2">
                <Field id="password" type="password" name="password" rules="required|min:4" placeholder="Mot de passe" class="form-control mb-0 ps-5" v-model="password" />
                <span class="text-danger special-danger" id="password-error" v-show="errors.password">
                  {{ errors.password  }}
                </span>
              </div>
            </div>

            <div class="form-group">
              <div class="mb-2 text-left">
                <input type="checkbox" name="remember" class="float-left me-2" style="width:unset; height:22px" /><span>Remember Me</span>

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
              <button type="submit" value="Submit">Se Connecter</button>
            </div>
            <!-- {{ trans.get('labels.frontend.passwords.forgot_password') }} -->
            <!-- route('frontend.auth.password.reset') -->
            <router-link :to="{ name :'password.reset'}" class="special p-0 d-block text-center my-3">Avez-vous oublié votre mot de passe&nbsp;?</router-link>
            <!-- <a href="https://fxinstitut.test/password/reset" class="special p-0 d-block text-center my-3">Avez-vous oublié votre mot de passe&nbsp;?</a> -->
          </Form>
        </div><!-- card-body -->
      </div><!-- card -->
    </div><!-- col-6 -->
  </div><!-- row -->

</template>

<script setup>
import { ref } from "@vue/reactivity";
import { nextTick, watch } from "@vue/runtime-core";
import { Field, Form, useForm } from "vee-validate";
import { useRoute } from "vue-router";

const email = ref("");
const password = ref("");
const prevRoute = ref(null);
const route = useRoute();
const success = ref("");
const { handleSubmit } = useForm();
const emit = defineEmits(["hideModal"]);

watch(
  () => route.path,
  (currentPath, prevPath) => {
    prevRoute.value = currentPath !== prevPath ? prevPath : null;
  }
);

const onSubmit = handleSubmit(async (values, { resetForm }) => {
  console.log(values);
  const userdata = {
    email: email.value,
    password: password.value,
  };
});
</script>

