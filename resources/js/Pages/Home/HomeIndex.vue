
<template>

    <Head>
        <title>Home</title>
        <meta name="description" content="The Home Information" head-key="description">
    </Head>



    <div class="pt-2 sm:pt-4 lg:pt-2 lg:pb-3">
        <div class="mx-auto max-w-7xl lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                <div
                    class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 sm:text-center lg:flex lg:items-center lg:px-0 lg:text-left">
                    <div class="lg:py-12">
                        <a href="#"
                            class="inline-flex items-center rounded-full bg-black p-1 pr-2 text-white hover:text-gray-200 sm:text-base lg:text-sm xl:text-base">
                            <span
                                class="rounded-full bg-amber-500 px-3 py-0.5 text-sm font-semibold leading-5 text-white">We're
                                hiring</span>
                            <span class="ml-4 text-sm">Visit our careers page</span>
                            <ChevronRightIcon class="ml-2 h-5 w-5 text-gray-500" aria-hidden="true" />
                        </a>
                        <h1
                            class="mt-4 text-4xl font-bold tracking-tight text-white sm:mt-5 sm:text-6xl lg:mt-6 xl:text-6xl">
                            <span class="block">A better way to</span>
                            <span class="block text-amber-400">ship web apps</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">Anim
                            aute id magna aliqua ad ad non deserunt sunt. Qui irure qui Lorem cupidatat commodo.
                            Elit sunt amet fugiat veniam occaecat fugiat.</p>

                    </div>
                </div>
                <div class="mt-12 -mb-16 sm:-mb-48 lg:relative lg:m-0">
                    <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 lg:max-w-none lg:px-0">
                        <!-- Illustration taken from Lucid Illustrations: https://lucid.pixsellz.io/ -->
                        <!-- <img class="w-full lg:absolute lg:inset-y-0 lg:left-0 lg:h-full lg:w-auto lg:max-w-none"
                            src="https://tailwindui.com/img/component-images/cloud-illustration-indigo-400.svg"
                            alt="" /> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <HomeFeaturesSection01 />
    <HomeFeaturesSection03 />
    <HomeFeaturesSection04 />

    <!-- <HomeFeaturesSection02 /> -->

    <!-- More main page content here... -->


</template>


<script lang="ts">
// export default {
//     layout: null
// }
</script>
<script setup lang="ts">

import { ChevronRightIcon } from '@heroicons/vue/20/solid';

    // const props = defineProps({name: String});
</script>



