<template>
    <div :class="classes">
        <form @submit.prevent="submit">
            <div>
                <JetInputLabel for="email" value="Email" />
                <JetTextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
                    autofocus />
                <JetInputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <JetInputLabel for="password" value="Mot de passe" />
                <JetTextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
                    autocomplete="current-password" />
                <JetInputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between mt-3">
                <div class="flex items-center">
                    <JetCheckbox v-model:checked="form.remember" name="remember" />
                    <label for="remember-me" class="ml-2 block text-base text-gray-300">Se souvenir</label>
                </div>
                <!-- @if(config('access.captcha.registration'))
                                <div class="contact-info mb-2 text-center">
                                    {!! Captcha::display() !!}
                                    {{ html()->hidden('captcha_status', 'true') }}
                                    <span id="login-captcha-error" class="special-danger"></span>

                                </div>
                            @endif -->

                <div class="text-base">
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="font-medium text-base-200 hover:text-base-100">Avez-vous oublié votre mot de passe ?
                    </Link>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" :class="{ 'opacity-25 loading': form.processing }" :disabled="form.processing"
                    class="btn flex w-full justify-center rounded-full border border-transparent bg-base-200 py-2 px-4 text-md font-bold text-gray-800 shadow-sm hover:bg-base-400 hover:text-base-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2">
                    Se Connecter
                </button>
                <!-- <JetPrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Log in
                    </JetPrimaryButton> -->
            </div>
        </form>
        <div id="socialLinks" class="text-center mt-4 mb-5">
            <div class="text-center mb-3">
                <span>Réseaux Sociaux</span>
            </div>
            <div class="flex flex-col space-y-4">
                <a href="https://fxinstitut.test/login/facebook"
                    class="relative bg-[#3B5499] text-white w-full p-2 text-center block rounded-full">
                    <i class="fab fa-facebook" style="position:absolute; left:15px; margin-top:3px"></i>
                    <span>Se connecter avec Facebook</span>
                </a>
                <a href="https://fxinstitut.test/login/google"
                    class="relative bg-[#dd4b39] text-white w-full p-2 text-center block rounded-full">
                    <i class="fab fa-google" style="position:absolute; left:15px; margin-top:3px"></i>
                    <span>Se connecter avec Google</span>
                </a>
            </div>
        </div>
    </div>




</template>

<script setup lang="ts">


defineProps({
    canResetPassword: Boolean,
    status: String,
    classes: String
});

const modal = inject('modal');

const form = useForm({
    email: '',
    password: '',
    remember: false,
    redirect: ''
});

onMounted(() => {
    modal?.autoCloser(form)
})
// const Timeout = ref(setTimeout(() => {
//     modal.close()
// }, 5000))

// watch(form, () => {
//     clearTimeout(Timeout.value)
//     Timeout.value = setTimeout(() => {
//         modal.close()
//     }, 5000)
// })


watch(modal, (val) => {
    if (val.isOpen === false) form.reset();
    form.redirect = val.redirect
})

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'), onSuccess: (res) => modal.close(true)
    });
};

</script>

