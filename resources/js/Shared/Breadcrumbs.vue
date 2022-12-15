<template>

    <nav class="flex" aria-label="Breadcrumb">
        <ol v-if="(breadcrumbs?.length > 0)" role="list" class="flex items-center space-x-2">
            <li>
                <div>
                    <Link v-route-back :href="route('frontend.index')" class="text-gray-300 hover:text-base-200">
                    <!-- Heroicon name: mini/home -->
                    <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Home</span>
                    </Link>
                </div>
            </li>
            <template v-for="(item, index) in breadcrumbs">


                <li v-if="item?.href">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                        </svg>
                        <Link v-route-back :href="route(item.href)"
                            class="ml-2 text-sm font-medium text-gray-300 hover:text-base-200">
                        {{ item.name }}
                        </Link>
                    </div>
                </li>
                <li v-if="(index < 1) && prevRoute && (prevRoute.params.category || prevRoute.params.tag)">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                        </svg>
                        <Link v-route-back :href="route(prevRoute.name, prevRoute.params)"
                            class="ml-2 text-sm font-medium text-gray-300 hover:text-base-200">{{
                                    prevRoute.params.category ? prevRoute.params.category :
                                        prevRoute.params.tag
                            }}</Link>
                    </div>
                </li>


                <li v-if="!item?.href">

                    <div class="flex items-center">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                        </svg>
                        <Link v-route-back href="#" class="ml-2 text-sm font-medium text-gray-300 hover:text-base-200"
                            aria-current="page">
                        {{ item.name.split('-').join(' ') }}
                        </Link>
                    </div>

                </li>
            </template>
        </ol>
    </nav>


    <!-- <div class="text-sm breadcrumbs">
        <ul v-if="(breadcrumbs?.length > 0)">
            <template v-for="(item, index) in breadcrumbs">
                <li v-if="item?.href" class="breadcrumb-item">
                    <Link v-route-back :href="route(item.href)" class="breadcrumb-item">
                    {{ item.name }}
                    </Link>
                </li>
                <li v-if="(index < 1) && prevRoute && (prevRoute.params.category || prevRoute.params.tag)"
                    class="breadcrumb-item">
                    <Link v-route-back :href="route(prevRoute.name, prevRoute.params)" class="breadcrumb-item">{{
                            prevRoute.params.category ? prevRoute.params.category :
                                prevRoute.params.tag
                    }}</Link>
                </li>
                <li v-if="!item?.href" class="breadcrumb-item active" aria-current="page">
                    {{ item.name.split('-').join(' ') }}
                </li>

            </template>
        </ul>
    </div> -->



</template>
<script setup lang="ts">


const breadcrumbs = inject('breadcrumbs');


// const getPrev = () => routeBack.value = true


const prevRoute = ref(null);

</script>
