<template>
    <nav v-if="small === true" class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3"
        aria-label="Pagination">
        <div class="flex flex-1 justify-between">
            <Link href="#"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
            Previous</Link>
            <Link href="#"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
            Next</Link>
        </div>
    </nav>
    <!-- Pagination -->
    <nav v-else class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
        aria-label="Pagination">
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Showing
                {{ ' ' }}
                <span class="font-medium">1</span>
                {{ ' ' }}
                to
                {{ ' ' }}
                <span class="font-medium">10</span>
                {{ ' ' }}
                of
                {{ ' ' }}
                <span class="font-medium">20</span>
                {{ ' ' }}
                results
            </p>
        </div>
        <div class="flex flex-1 justify-between sm:justify-end">
            <Link href="#"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Previous</Link>
            <Link href="#"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Next</Link>
        </div>
    </nav>
</template>

<script setup lang="ts">

defineProps({
    small: Boolean
})
</script>

