<script setup lang="ts">


const form = useForm({
    password: '',
});

const passwordInput = ref(null);

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();

            passwordInput.value.focus();
        },
    });
};
</script>

<template>

    <Head title="Secure Area" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form @submit.prevent="submit">
            <div>
                <JetInputLabel for="password" value="Password" />
                <JetTextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                    class="mt-1 block w-full" required autocomplete="current-password" autofocus />
                <JetInputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex justify-end mt-4">
                <JetPrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </JetPrimaryButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
