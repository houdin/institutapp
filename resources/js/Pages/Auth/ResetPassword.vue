<script setup lang="ts">


const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head title="Reset Password" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit">
            <div>
                <JetInputLabel for="email" value="Email" />
                <JetTextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
                    autofocus />
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

            <div class="flex items-center justify-end mt-4">
                <JetPrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </JetPrimaryButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
