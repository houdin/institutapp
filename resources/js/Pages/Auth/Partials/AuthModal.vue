<template>

    <AppModal v-if="modal.container != null" :outside="outside">
        <template #header>
            <AppTitle v-if="switcher == true" title="Se| Connecter"
                :classes="'mt-6 text-center tracking-tight' + (modal.open ? 'opacity-100' : 'opacity-0') + ' ' + classAnim">
                <p class="mt-2 text-center text-md">Vous n'avez pas encore de compte?
                    <!-- <Link :href="route('register')" class="go-register special">S'inscrire</Link> -->
                    <span class="cursor-pointer text-base-200 font-bold" @click="switchModalType()">S'inscrire</span>
                    <!-- <a href="" class="go-register special" @click.prevent="switching()">S'inscrire</a> -->
                </p>
            </AppTitle>
            <AppTitle v-if="switcher == false" title="S'inscrire"
                :classes="'mt-6 text-center tracking-tight' + (modal.open ? 'opacity-100' : 'opacity-0') + ' ' + classAnim">
                <p class="mt-2 text-center text-md">Vous avez déja un compte?
                    <span class="cursor-pointer text-base-200 font-bold" @click="switchModalType()">Se
                        Connecter</span>
                    <!-- <Link :href="route('login')" class="go-register special">Se Connecter</Link> -->
                    <!-- <a href="" class="go-register special" @click.prevent="switching()">S'inscrire</a> -->
                </p>
            </AppTitle>
        </template>
        <template #default>
            <LoginFormModal v-if="switcher == true"
                :classes="(modal.open ? 'opacity-100' : 'opacity-0') + ' mt-3 sm:mt-5 ' + classAnim" />
            <RegisterFormModal v-if="switcher == false"
                :classes="(modal.open ? 'opacity-100' : 'opacity-0') + ' mt-3 sm:mt-5 ' + classAnim" />
        </template>

        <template #action>

        </template>
    </AppModal>
</template>

<script setup lang="ts">

const props = defineProps({
    outside: Boolean
})

const classAnim = ref('');

const switcher = ref(true);

const modal = inject('modal');


const switchModalType = async () => {
    switcher.value = await modal.switch(switcher.value)
}


watch(switcher, (current) => {

    if (current == true) {
        classAnim.value = 'ease-out duration-500'
    } else {
        classAnim.value = 'ease-in duration-400'
    }

})
</script>
