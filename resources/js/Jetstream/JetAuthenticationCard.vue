<template>
    <div class="flex min-h-full flex-col justify-center sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">

            <slot name="logo" />
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">

            <div class="bg-gray-800 py-8 px-4 shadow-md sm:rounded-lg sm:px-10">
                <slot />
            </div>
        </div>
    </div>
</template>
