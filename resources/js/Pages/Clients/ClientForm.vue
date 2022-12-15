
<template>
    <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="form.post('/clients', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            openModal = false
        },
        onError: (errors) => {
            console.log(errors)
        }
    })">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                    <div class="sm:col-span-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Client Name</label>
                        <div class="mt-1">
                            <input v-model="form.name" type="text" name="name" id="name"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea v-model="form.description" id="description" name="description" rows="3"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>


                </div>
            </div>




        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="button" @click="openModal = false"
                    class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</button>
                <button type="submit"
                    class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">

import { ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const openModal = inject('openModal')


const props = defineProps({
    masks: {
        input: 'dd/MM/yyyy',
    }

})

const form = useForm({
    name: 'This is my fisrt Project',
    description: 'This is description for this project'
})



// function addProject() {
//     console.log("Housisis")

//     form.post('/projects', {
//         preserveScroll: true,
//         onSuccess: () => form.reset(),
//         onError: (errors) => {
//             console.log(errors)
//         }
//     })
//     Inertia.reload()

// }
</script>
