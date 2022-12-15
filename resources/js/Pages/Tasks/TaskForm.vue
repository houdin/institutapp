
<template>
    <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="form.post('/tasks', {
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
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea v-model="form.description" id="description" name="description" rows="3"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <select id="location" name="location"
                                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                <option>United States</option>
                                <option selected="">Canada</option>
                                <option>Mexico</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-base font-medium text-gray-900">Priority</label>
                        <fieldset class="mt-4">
                            <legend class="sr-only">Priority</legend>
                            <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                <div v-for="priority in priorities" :key="priority.id" class="flex items-center">
                                    <input v-model="form.priority" :id="priority.id" :value="priority.id"
                                        name="priority" type="radio" :checked="priority.id === 3"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                    <label :for="priority.id" class="ml-3 block text-sm font-medium text-gray-700">{{
                                            priority.title
                                    }}</label>
                                </div>
                            </div>
                        </fieldset>
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

import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon } from '@heroicons/vue/24/outline'

import { ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const priorities = [
    { id: '1', title: '1' },
    { id: '2', title: '2' },
    { id: '3', title: '3' },
    { id: '4', title: '4' },
    { id: '5', title: '5' },
]

const openModal = inject('openModal')


const form = useForm({
    description: 'This is description for this project',
    priority: 3,
    project_id: usePage().props.value.projects[0]
})



// let selected = ref(usePage().props.value.projects[0])


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
