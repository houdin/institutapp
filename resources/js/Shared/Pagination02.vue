<template>


    <nav class="my-8 flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        <template v-for="(link, index) in links">
            <div v-if="index === 0 && isNaN(parseInt(link.label))" class="-mt-px flex w-0 flex-1">
                <Component :is="link.url ? 'Link' : 'span'"
                    class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium hover:border-gray-300 "
                    :class="link.url ? 'text-gray-300 hover:text-base-200' : 'text-gray-500'" :href="link.url">
                    <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z"
                            clip-rule="evenodd" />
                    </svg>
                    Précédent
                </Component>
            </div>

        </template>
        <div class="hidden md:-mt-px md:flex">

            <template v-for="(link, index) in links">

                <Component :is="link.url ? 'Link' : 'span'" v-if="index !== 0 && parseInt(link.label)" :href="link.url"
                    v-html="link.label"
                    class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium  hover:border-gray-300 hover:text-base-200"
                    :class="{ 'text-gray-500': !link.url, 'font-bold text-base-200': link.active, 'text-gray-300': !link.active }" />

            </template>

        </div>
        <div v-if="links[links?.length - 1] && isNaN(parseInt(links[links?.length - 1].label))"
            class="-mt-px flex w-0 flex-1 justify-end">

            <Component :is="links[links?.length - 1].url ? 'Link' : 'span'"
                class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium hover:border-gray-300 "
                :class="links[links?.length - 1].url ? 'text-gray-300 hover:text-base-200' : 'text-gray-500'"
                :href="links[links?.length - 1].url">
                Suivant
                <svg class="ml-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                        clip-rule="evenodd" />
                </svg>
            </Component>
        </div>
    </nav>

</template>

<script setup lang="ts">

defineProps({ links: Array })

</script>
