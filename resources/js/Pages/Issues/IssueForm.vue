
<template>
    <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="form.post('/issues', {
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
                        <Listbox as="div" v-model="form.project_id">
                            <ListboxLabel class="block text-sm font-medium text-gray-700">Select a Client
                            </ListboxLabel>
                            <div class="relative mt-1">
                                <ListboxButton
                                    class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                    <span class="block truncate">{{ form.project_id.name }}</span>
                                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition leave-active-class="transition ease-in duration-100"
                                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                                    <ListboxOptions
                                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                        <ListboxOption as="template" v-for="project in $page.props.projects"
                                            :key="project.id" :value="project" v-slot="{ active, selected }">
                                            <li
                                                :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-8 pr-4']">
                                                <span
                                                    :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{
                                                            project.name
                                                    }}</span>

                                                <span v-if="selected"
                                                    :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 left-0 flex items-center pl-1.5']">
                                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                            </li>
                                        </ListboxOption>
                                    </ListboxOptions>
                                </transition>
                            </div>
                        </Listbox>
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



let selected = ref(usePage().props.value.projects[0])


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
