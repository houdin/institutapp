<template>
    <Listbox as="div" v-model="selected">
        <ListboxLabel class="sr-only"> Change published status </ListboxLabel>
        <div class="relative">
            <div class="inline-flex divide-x divide-indigo-600 rounded-md shadow-sm">
                <div class="inline-flex divide-x divide-indigo-600 rounded-md shadow-sm">
                    <div
                        class="inline-flex items-center rounded-l-md border border-transparent bg-indigo-500 py-2 pl-3 pr-4 text-white shadow-sm">
                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                        <p class="ml-2.5 text-sm font-medium">{{ selected.title }}</p>
                    </div>
                    <ListboxButton
                        class="inline-flex items-center rounded-l-none rounded-r-md bg-indigo-500 p-2 text-sm font-medium text-white hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                        <span class="sr-only">Change published status</span>
                        <ChevronDownIcon class="h-5 w-5 text-white" aria-hidden="true" />
                    </ListboxButton>
                </div>
            </div>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <ListboxOptions
                    class="absolute right-0 z-10 mt-2 w-72 origin-top-right divide-y divide-gray-200 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <ListboxOption as="template" v-for="option in publishingOptions" :key="option.title" :value="option"
                        v-slot="{ active, selected }">
                        <li
                            :class="[active ? 'text-white bg-indigo-500' : 'text-gray-900', 'cursor-default select-none p-4 text-sm']">
                            <div class="flex flex-col">
                                <div class="flex justify-between">
                                    <p :class="selected ? 'font-semibold' : 'font-normal'">{{ option.title }}</p>
                                    <span v-if="selected" :class="active ? 'text-white' : 'text-indigo-500'">
                                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                    </span>
                                </div>
                                <p :class="[active ? 'text-indigo-200' : 'text-gray-500', 'mt-2']">{{ option.description
                                }}</p>
                            </div>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronDownIcon } from '@heroicons/vue/20/solid'

const publishingOptions = [
    { title: 'Published', description: 'This job posting can be viewed by anyone who has the link.', current: true },
    { title: 'Draft', description: 'This job posting will no longer be publicly accessible.', current: false },
]

const selected = ref(publishingOptions[0])
</script>



<template>
    <Listbox as="div" v-model="selected">
        <ListboxLabel class="block text-sm font-medium text-gray-700">Assigned to</ListboxLabel>
        <div class="relative mt-1">
            <ListboxButton
                class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                <span class="flex items-center">
                    <span :aria-label="selected.online ? 'Online' : 'Offline'"
                        :class="[selected.online ? 'bg-green-400' : 'bg-gray-200', 'inline-block h-2 w-2 flex-shrink-0 rounded-full']" />
                    <span class="ml-3 block truncate">{{ selected.name }}</span>
                </span>
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                    <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
            </ListboxButton>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <ListboxOptions
                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    <ListboxOption as="template" v-for="person in people" :key="person.id" :value="person"
                        v-slot="{ active, selected }">
                        <li
                            :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                            <div class="flex items-center">
                                <span
                                    :class="[person.online ? 'bg-green-400' : 'bg-gray-200', 'inline-block h-2 w-2 flex-shrink-0 rounded-full']"
                                    aria-hidden="true" />
                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                                    {{ person.name }}
                                    <span class="sr-only"> is {{ person.online ? 'online' : 'offline' }}</span>
                                </span>
                            </div>

                            <span v-if="selected"
                                :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                            </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script setup>
import { ref } from 'vue'
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const people = [
  { id: 1, name: 'Wade Cooper', online: true },
  { id: 2, name: 'Arlene Mccoy', online: false },
  { id: 3, name: 'Devon Webb', online: false },
  { id: 4, name: 'Tom Cook', online: true },
  { id: 5, name: 'Tanya Fox', online: false },
  { id: 6, name: 'Hellen Schmidt', online: true },
  { id: 7, name: 'Caroline Schultz', online: true },
  { id: 8, name: 'Mason Heaney', online: false },
  { id: 9, name: 'Claudie Smitham', online: true },
  { id: 10, name: 'Emil Schaefer', online: false },
]

const selected = ref(people[3])
</script>
