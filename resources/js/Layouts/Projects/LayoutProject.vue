
<template>
    <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-gray-100">
    <body class="h-full">
    ```
  -->
    <div class="min-h-full">

        <Sidebar></Sidebar>

        <div class="flex flex-1 flex-col lg:pl-64">

            <HeaderBar></HeaderBar>

            <main class="flex-1 pb-8">
                <!-- Page header -->

                <Header></Header>
                <div class="mt-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">



const sidebarOpen = ref(false)

provide('sidebarOpen', sidebarOpen)

</script>
