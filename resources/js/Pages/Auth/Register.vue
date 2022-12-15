<script setup lang="ts">

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head title="Register" />

    <JetAuthenticationCard>
        <template #logo>
            <AppTitle title="S'inscrire" classes="mt-6 text-center tracking-tight">
                <p class="mt-2 text-center text-md">Vous avez déja un compte?
                    <Link :href="route('login')" class="go-register special">Se Connecter</Link>
                    <!-- <a href="" class="go-register special" @click.prevent="switching()">S'inscrire</a> -->
                </p>
            </AppTitle>

        </template>

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
                                class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a
                                target="_blank" :href="route('policy.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                    <JetInputError class="mt-2" :message="form.errors.terms" />
                </JetInputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Already registered?
                </Link>

                <JetPrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </JetPrimaryButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
