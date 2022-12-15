<template>
    <div class="container mx-auto mb-6">
        <div class="px-4 sm:px-6 lg:px-8">
            <div v-if="showDetail === true" class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <div class="flex">
                        <Component v-if="icon.length" :is="heroIcons[icon]" class="mr-3 h-6 w-6 text-gray-400"
                            aria-hidden="true" />
                        <h1 class="text-xl font-semibold text-gray-900">{{ type.charAt(0).toUpperCase()
                                + type.slice(1)
                        }}</h1>
                    </div>
                    <!-- <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including
                        their
                        name,
                        title, email and role.</p> -->
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button @click="modalDetail(type)" type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        ADD {{ type.toUpperCase() }}
                    </button>
                </div>
            </div>
            <!-- Sidebar Search -->
            <div class="mt-2 px-3">
                <label for="search" class="sr-only">Search</label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                        aria-hidden="true">
                        <Component :is="heroIcons['MagnifyingGlassIcon']" class="mr-3 h-4 w-4 text-gray-400"
                            aria-hidden="true" />
                    </div>
                    <input type="text" name="search" id="search"
                        class="block w-full rounded-md border-gray-300 pl-9 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search" />
                </div>
            </div>
            <div class="mt-4 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <template v-for="head in header">
                                            <th v-if="head === 'Status'" scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                <div class="flex items-center">

                                                    <div>Status</div><span>
                                                        <Component :is="heroIcons['ArrowLongUpIcon']" class="h-6 w-6"
                                                            aria-hidden="true" />
                                                    </span>
                                                </div>
                                            </th>
                                            <th v-else scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                {{ head }}</th>

                                        </template>

                                        <!-- <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Name</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Client</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Due</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Action</th> -->

                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="item in data" :key="item.id">
                                        <template v-for="head in header">
                                            <td v-if="head === 'Status'"
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                <Component :is="heroIcons['CheckCircleIcon']"
                                                    v-if="parseInt(item.completed)" class="mr-3 h-6 w-6 text-gray-400"
                                                    aria-hidden="true" @click="incompleteitem(item.id)" />
                                                <Component :is="heroIcons['XCircleIcon']"
                                                    v-else-if="!parseInt(item.completed) && item.due_date != '' && item.due_date != null && new Date(item.due_date) < Date.now()"
                                                    class="mr-3 h-6 w-6 text-gray-400" aria-hidden="true"
                                                    @click="completeitem(item.id)" />
                                                <Component :is="heroIcons['ExclamationCircleIcon']"
                                                    v-else-if="!parseInt(item.completed)" @click="completeitem(item.id)"
                                                    class="mr-3 h-6 w-6 text-gray-400" aria-hidden="true" />

                                            </td>


                                            <td v-else-if="head === 'Actions'">
                                                <div class="flex justify-end items-center">
                                                    <Link v-if="showDetail !== true && type !== 'file'"
                                                        :href="`/${type}s/${item.id}`"
                                                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                                                    View</Link>
                                                    <Link v-if="showDetail === true && type !== 'file'"
                                                        @click="typeChange(type, item)" preserve-state preserve-scroll
                                                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                                                    Edit</Link>
                                                    <button type="button" @click="deleteitem(item.id)"
                                                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Delete</button>
                                                </div>

                                            </td>
                                            <td v-else class="px-3 py-4 text-sm text-gray-500"
                                                :class="head === 'Description' ? 'whitespace-nowrap' : 'whitespace-nowrap'">
                                                {{ head ===
                                                        "Project" ? item.project.name : head === 'Description' ?
                                                        truncate(item.description, 80) : head ===
                                                            "Client" ? item.client.name : item[head === 'Due' ?
                                                                'due_date'
                                                                :
                                                                head.toLowerCase().split(' ').join('_')]
                                                }}
                                            </td>

                                        </template>


                                        <!-- <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{
                                                item.client.name
                                        }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{
                                                item.due_date
                                        }}
                                        </td> -->

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <EditSlide :type="typeSlide" :data="slideData"></EditSlide>


</template>

<script setup lang="ts">

import * as heroIcons from '@heroicons/vue/24/outline';

const props = defineProps({
    data: Object,
    header: Array,
    type: String,
    icon: String,
    showDetail: Boolean
});

let modaltype = ref('');
let openSlide = ref(false)
let typeSlide = ref('');
let slideData = reactive({});

const typeChange = (val, item) => {
    typeSlide.value = val;
    slideData.value = item
    openSlide.value = true

}

let modalData = props.showDetail === true ? inject('modalData') : false

function modalDetail(typ) {
    if (props.showDetail === true) {
        modalData.open = true;
        modalData.type = typ;
    }


}

watch(openSlide, (current, prev) => {
    if (current === false) {
        slideData.value = {};
        typeSlide.value = '';
    }

})

provide('openSlide', openSlide)

const pagination = {
    sortBy: 'completed',
    rowsPerPage: -1
}

const truncate = (data, num) => {
    const reqdString =
        data.split("").slice(0, num).join("");
    return reqdString + "...";
}

const completeProject = (project_id) => {
    Inertia.post('/projects/' + project_id + '/complete', {
        preserveScroll: true
    })
    Inertia.reload()

}
const incompleteProject = (project_id) => {
    Inertia.post('/projects/' + project_id + '/incomplete', {
        preserveScroll: true
    })
    Inertia.reload()

}
const deleteProject = (project_id) => {
    Inertia.delete('/projects/' + project_id, {
        preserveScroll: true
    })
    Inertia.reload()

}
</script>

