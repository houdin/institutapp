<template>
    <div class="h-20 my-9 flex justify-center items-center">

        <nav aria-label="Page navigation example">
            <ul class="inline-flex -space-x-px">
                <template v-for="(link, index) in links">
                    <li v-if="index === 0 && isNaN(parseInt(link.label))">
                        <Component :is="link.url ? 'Link' : 'span'"
                            class="pr-3 pl-5 py-2 ml-0 leading-tight border rounded-l-lg bg-gray-800 border-gray-700 "
                            :class="link.url ? 'text-gray-300 hover:text-base-200 hover:bg-gray-700' : 'text-gray-500 '"
                            :href="link.url">
                            Précédent
                        </Component>

                    </li>
                </template>
                <template v-for="(link, index) in links">
                    <li>

                        <Component :is="link.url ? 'Link' : 'span'" v-if="index !== 0 && parseInt(link.label)"
                            :href="link.url" v-html="link.label" class="px-3 py-2  border border-gray-300"
                            :class="{ 'text-gray-500': !link.url, 'bg-gray-700 text-gray-500 border-gray-700 ': link.active, 'leading-tight bg-gray-800 text-gray-300 hover:text-base-200 hover:bg-gray-700 border-gray-700 ': !link.active }"
                            :aria-current="link.active ? 'page' : null" />

                    </li>
                </template>
                <li v-if="links[links?.length - 1] && isNaN(parseInt(links[links?.length - 1].label))">


                    <Component :is="links[links?.length - 1].url ? 'Link' : 'span'"
                        class="pr-5 pl-3 py-2 leading-tight border rounded-r-lg bg-gray-800 border-gray-700 "
                        :class="links[links?.length - 1].url ? 'text-gray-300 hover:text-base-200 hover:bg-gray-700' : 'text-gray-500 '"
                        :href="links[links?.length - 1].url">
                        Suivant

                    </Component>

                </li>
            </ul>
        </nav>
    </div>



</template>

<script setup lang="ts">

defineProps({ links: Array })

</script>
