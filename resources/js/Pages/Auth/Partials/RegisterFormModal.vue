<template>
    <div :class="classes">
        <form @submit.prevent="submit">
            <div>
                <JetInputLabel for="name" value="Name" />
                <JetTextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="name" />
                <JetInputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <JetInputLabel for="email" value="Email" />
                <JetTextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required />
                <JetInputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <JetInputLabel for="password" value="Password" />
                <JetTextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
                    autocomplete="new-password" />
                <JetInputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <JetInputLabel for="password_confirmation" value="Confirm Password" />
                <JetTextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                    class="mt-1 block w-full" required autocomplete="new-password" />
                <JetInputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <JetInputLabel for="terms">
                    <div class="flex items-center">
                        <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')"
                                class="underline text-sm text-base-300 hover:text-base-200">Terms of Service</a> and <a
                                target="_blank" :href="route('policy.show')"
                                class="underline text-sm text-base-300 hover:text-base-200">Privacy Policy</a>
                        </div>
                    </div>
                    <JetInputError class="mt-2" :message="form.errors.terms" />
                </JetInputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">

                <JetPrimaryButton class="ml-4 bg-base-200 " :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Register
                </JetPrimaryButton>
            </div>
        </form>
        <div class="">
            <p style="font-size: 13px; line-height: 1.6">
                Ce formulaire utilise <a class="text-base-200"
                    href="https://www.google.com/recaptcha/intro/android.html">reCAPTCHA</a>
                afin de lutter contre le SPAM. L'utilisation de cette fonctionnalité est soumise aux
                <a class="text-base-200" href="https://www.google.com/intl/fr/policies/privacy/">Règles de
                    confidentialité</a>
                et aux <a class="text-base-200" href="https://www.google.com/intl/fr/policies/terms/">Conditions
                    d'utilisation</a> de
                Google.
            </p>
        </div>
    </div>




</template>

<script setup lang="ts">


defineProps({
    classes: String
});

const modal = inject('modal');


const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

onMounted(() => {

    modal?.autoCloser(form)
})

watch(modal, (val) => {
    if (val.open === false) form.reset();
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'), onSuccess: (res) => modal.close(true)
    });
};

</script>

