<template>
    <div class="relative py-6 sm:py-8 lg:py-10">
        <div class="mx-auto max-w-md px-6 text-center sm:max-w-3xl lg:max-w-7xl lg:px-8">
            <h2 class="text-lg font-semibold text-primary">Deploy faster</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-300 sm:text-4xl">Tout ce dont vous avez besoin
                pour reussir vos projets</p>
            <p class="mx-auto mt-5 max-w-prose text-xl ">Phasellus lorem quam molestie id quisque diam
                aenean
                nulla in. Accumsan in quis quis nunc, ullamcorper malesuada. Eleifend condimentum id viverra nulla.</p>
            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div v-for="solution in $page.props.solutions" :key="solution.id" class="pt-6">
                        <div class="relative flow-root rounded-lg px-6 pb-8 shadow-lg">
                            <div class="top-0 left-0 absolute w-full h-full -z-10 rounded-lg "
                                :class="`bg-gray-${([7, 7][Math.round(Math.random())])}00`">
                            </div>
                            <div class="relative">
                                <div class="absolute ">
                                    <Link :href="'/' + solution.slug">
                                    <span class="inline-flex items-center justify-center rounded-xl "
                                        :style="{ color: solution.color }">
                                        <AppHeroIcon size="w-12 h-12" :item="solution.slug" />

                                    </span>
                                    </Link>
                                </div>
                                <h2 class="mt-8 text-2xl font-bold leading-8 tracking-tight text-gray-200">
                                    <Link :href="'/' + solution.slug">{{
                                            solution.name
                                    }}</Link>
                                </h2>
                                <p class="mt-5 text-sm leading-6 ">
                                    <Link :href="'/' + solution.slug">
                                    {{ solution.description }}
                                    </Link>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</template>

<script setup lang="ts">

</script>

