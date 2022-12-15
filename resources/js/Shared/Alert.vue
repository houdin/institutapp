<template>

    <div class="rounded-md bg-red-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Project was due {{ item.due_date }}
                </h3>

            </div>
        </div>
    </div>

    <div class="rounded-md bg-yellow-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Project is due {{ item.due_date
                }}</h3>

                <h3 class="text-sm font-medium text-yellow-800">Project is incomplete.</h3>

            </div>
        </div>
    </div>

    <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">Project completed {{
                        item.completed_date
                }}</p>
            </div>

        </div>
    </div>
</template>

<script setup lang="ts">
import { CheckCircleIcon, ExclamationTriangleIcon, XCircleIcon } from '@heroicons/vue/20/solid'

defineProps({
    item: Object,
    type: String,
    message: String
})
</script>
