
<template>
    <!-- When the mobile menu is open, add `overflow-hidden` to the `body` element to prevent double scrollbars -->


    <div class="container mx-auto">

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="container flex justify-center">
                <button @click="openModal = true" type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    <PlusIcon class="mr-3 h-4 w-4 text-gray-400" aria-hidden="true" />NEW PROJECT
                </button>
            </div>

            <Modal type="project"></Modal>

            <ItemsViewer :data="projects" :header="$page.props.headerTable.project.project" type="project"
                icon="MagnifyingGlassIcon">
            </ItemsViewer>
        </div>
    </div>




</template>


<script setup lang="ts">

import { PlusIcon } from '@heroicons/vue/20/solid'


const openModal = ref(false)
provide('openModal', openModal)


defineProps({
    projects: Object,
    clients: Object
})


</script>

