<template>
    <h2 class="text-lg font-medium leading-6 text-gray-900">Overview</h2>
    <div class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Card -->
        <div v-for="card in cards" :key="card.name" class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <component :is="card.icon" class="h-6 w-6 text-gray-400" aria-hidden="true" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-lg font-medium text-gray-500">{{ card.name }}
                            </dt>
                            <dd>
                                <h1 class="text-5xl font-medium text-gray-600">{{ card.amount }}
                                </h1>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <Link :href="card.href" class="font-medium text-cyan-700 hover:text-cyan-900">View
                    all</Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

import {

    ScaleIcon,

} from '@heroicons/vue/24/outline'
const cards = [
    { name: 'Projects', href: '/projects', icon: ScaleIcon, amount: usePage().props.value.projectsLen },
    { name: 'Clients', href: '/clients', icon: ScaleIcon, amount: usePage().props.value.clientsLen },
    { name: 'Tasks', href: '/tasks', icon: ScaleIcon, amount: usePage().props.value.tasksLen },
    // More items...
]

</script>
