<script setup lang="ts">
defineProps({
    classes: String
});

const show = ref(false);
const style = computed(() => usePage().props.value.flash?.bannerStyle || 'success');
const message = computed(() => usePage().props.value.flash?.banner);

watch(message, async () => {
    show.value = true;
});
</script>

<template>
    <div :class="classes">
        <!-- show && message -->
        <div v-if="show"
            :class="{ 'bg-gradient-to-r from-gray-900 via-green-800 to-green-600': style == 'success', 'bg-gradient-to-r from-gray-900 via-red-900 to-red-700': style == 'danger' }">
            <div class="max-w-screen-xl mx-auto py-1 px-3 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 flex items-center min-w-0">
                        <span class="flex p-1 rounded-lg"
                            :class="{ 'bg-green-600': style == 'success', 'bg-red-600': style == 'danger' }">
                            <AppHeroIcon :item="style" size="w-7 h-7" color="text-white" />
                        </span>

                        <p class="ml-3 font-medium text-sm text-gray-100 truncate">
                            {{ message }}
                        </p>
                    </div>

                    <div class="order-3 mt-2 w-full flex-shrink-0 sm:order-2 sm:mt-0 sm:w-auto">
                        <a href="#"
                            class="flex items-center justify-center rounded-md border border-transparent bg-white px-4 py-2 text-sm font-medium text-indigo-600 shadow-sm hover:bg-indigo-50">Learn
                            more</a>
                    </div>

                    <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                        <button type="button" class="-mr-1 flex p-2 rounded-md focus:outline-none sm:-mr-2 transition"
                            :class="{ 'hover:bg-green-600 focus:bg-green-600': style == 'success', 'hover:bg-red-600 focus:bg-red-600': style == 'danger' }"
                            aria-label="Dismiss" @click.prevent="show = false">
                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
