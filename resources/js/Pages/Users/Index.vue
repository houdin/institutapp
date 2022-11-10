
<template>

    <Head title="Users" />

    <div class="flex justify-between mb-6">
        <div class="flex items-center">
            <h1 class="text-4xl font-bold">Users</h1>

            <Link href="/users/create" class="text-blue-500 text-sm ml-3">Create New User</Link>
        </div>


        <input v-model="search" type="text" placeholder="Search..." class="border px-2 rounded-lg">
    </div>
    <div class="px-4 sm:px-6 lg:px-8">

        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">

                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                        <div class="flex items-center">

                                            <div class="">
                                                <div class="font-medium text-gray-900">{{ user.name }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <Link :href="`/users/${user.id}/edit`"
                                            class="text-indigo-600 hover:text-indigo-900" preserve-scroll>Edit</Link>
                                    </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>

                </div>
                <div>

                    <NewPagination :links="users.links" />


                </div>

            </div>
        </div>
    </div>



</template>

<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia';


let props = defineProps({
    users: Object,
    filters: Object
})

let search = ref(props.filters.search);

watch(search, value => {
    Inertia.get('/users', { search: value }, { preserveState: true, replace: true })
})
</script>
