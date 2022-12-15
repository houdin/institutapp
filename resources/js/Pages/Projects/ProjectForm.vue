
<template>
    <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="form.post('/projects', {
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
                        <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                        <div class="mt-1">
                            <input v-model="form.name" type="text" name="name" id="name"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <Listbox as="div" v-model="form.client_id">
                            <ListboxLabel class="block text-sm font-medium text-gray-700">Select a Client
                            </ListboxLabel>
                            <div class="relative mt-1">
                                <ListboxButton
                                    class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                    <span class="block truncate">{{ form.client_id.name }}</span>
                                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </span>
                                </ListboxButton>

                                <transition leave-active-class="transition ease-in duration-100"
                                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                                    <ListboxOptions
                                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                        <ListboxOption as="template" v-for="client in $page.props.clients"
                                            :key="client.id" :value="client" v-slot="{ active, selected }">
                                            <li
                                                :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-8 pr-4']">
                                                <span
                                                    :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{
                                                            client.name
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
                    <div class="sm:col-span-6 flex flex-col">
                        <span class="text-sm text-gray-700">Due Date</span>
                        <date-picker v-model="form.due_date" :is-expanded="true" mode="date" :masks="masks" />

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

import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon } from '@heroicons/vue/24/outline'

import { ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const openModal = inject('openModal')

let datepicked = ref()

const props = defineProps({
    masks: {
        input: 'dd/MM/yyyy',
    }

})

const form = useForm({
    name: 'This is my fisrt Project',
    description: 'This is description for this project',
    due_date: new Date(),
    client_id: usePage().props.value.clients[0]
})



let selected = ref(usePage().props.value.clients[0])


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
