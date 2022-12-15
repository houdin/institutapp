<template>

    <AppModal v-if="modal.container != null" :outside="outside">
        <template #header>
            <!-- <AppTitle title="Recherche"
                :classes="'mt-6 text-center tracking-tight' + (modal.isOpen ? 'opacity-100' : 'opacity-0') + ' ' + classes">
                <p class="mt-2 text-center text-md">Aucun element trouvé !
                    <span class="cursor-pointer text-base-200 font-bold" @click="switchModalType()">14</span>
                </p>
            </AppTitle> -->

        </template>
        <template #default>
            <SearchFormModal :classes="(modal.isOpen ? 'opacity-100' : 'opacity-0') + ' ' + classes" />
        </template>

        <template #action>
            <!-- <AuthBottomAction v-if="switcher == true"
                :classes="(openModal ? 'opacity-100' : 'opacity-0') + ' ' + classes" /> -->
        </template>
    </AppModal>
</template>

<script setup lang="ts">

const props = defineProps({
    outside: Boolean
})

const classes = ref('');

const switcher = ref(true);

const modal = inject('modal');

const switchModalType = () => {
    switcher.value = modal.switch(switcher.value)
}

watch(switcher, (current) => {

    if (current == true) {
        classes.value = 'ease-out duration-500'
    } else {
        classes.value = 'ease-in duration-400'
    }

})
</script>
