<script setup lang="ts">


const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

const submit = () => {
    form.post(route('two-factor.login'));
};
</script>

<template>

    <Head title="Two-factor Confirmation" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            <template v-if="!recovery">
                Please confirm access to your account by entering the authentication code provided by your authenticator
                application.
            </template>

            <template v-else>
                Please confirm access to your account by entering one of your emergency recovery codes.
            </template>
        </div>

        <form @submit.prevent="submit">
            <div v-if="!recovery">
                <JetInputLabel for="code" value="Code" />
                <JetTextInput id="code" ref="codeInput" v-model="form.code" type="text" inputmode="numeric"
                    class="mt-1 block w-full" autofocus autocomplete="one-time-code" />
                <JetInputError class="mt-2" :message="form.errors.code" />
            </div>

            <div v-else>
                <JetInputLabel for="recovery_code" value="Recovery Code" />
                <JetTextInput id="recovery_code" ref="recoveryCodeInput" v-model="form.recovery_code" type="text"
                    class="mt-1 block w-full" autocomplete="one-time-code" />
                <JetInputError class="mt-2" :message="form.errors.recovery_code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                    @click.prevent="toggleRecovery">
                    <template v-if="!recovery">
                        Use a recovery code
                    </template>

                    <template v-else>
                        Use an authentication code
                    </template>
                </button>

                <JetPrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </JetPrimaryButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
