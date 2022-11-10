<template>

    <Head>
        <title>Default Title</title>
        <meta name="description" content="This is the description for my App" head-key="description">
    </Head>
    <NavMenuHeader></NavMenuHeader>

    <transition name="custom-classes" mode="out-in" enter-active-class="animate__animated animate__fadeInLeft"
        leave-active-class="animate__animated animate__fadeOutRight" appear>
        <main :key="$page.url" class="container p-4 mx-auto mt-[60px] relative">
            <slot />
        </main>
    </transition>

    <Footer></Footer>

    <!-- <main>

        <slot />
    </main> -->
</template>


<script setup lang="ts">

//console.log(usePage.props)
// const username = computed(() => usePage().props.value.auth.user.username)

</script>

<style>

</style>
