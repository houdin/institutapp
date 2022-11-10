
<template>

    <Head title="Create User Page" />

    <h1 class="text-3xl">New User</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
        <div class="mb-6">
            <label for="first_name" class="block mb-2 uppercase font-blod text-xs text-gray-500">First Name</label>
            <input v-model="form.first_name" type="text" class="border border-gray-400 p-2 w-full rounded"
                id="first_name" name="first_name">

        </div>
        <div class="mb-6">
            <label for="last_name" class="block mb-2 uppercase font-blod text-xs text-gray-500">Last Name</label>
            <input v-model="form.last_name" type="text" class="border border-gray-400 p-2 w-full rounded" id="last_name"
                name="last_name">
        </div>
        <div class="mb-6">
            <label for="email" class="block mb-2 uppercase font-blod text-xs text-gray-500">Email</label>
            <input v-model="form.email" type="text" class="border border-gray-400 p-2 w-full rounded" id="email"
                name="email">
        </div>
        <div class="mb-6">
            <label for="password" class="block mb-2 uppercase font-blod text-xs text-gray-500">Password</label>
            <input v-model="form.password" type="password" class="border border-gray-400 p-2 w-full rounded"
                id="password" name="password">
        </div>
        <div class="mb-6">
            <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">Sumit</button>
        </div>
    </form>
</template>

<script setup lang="ts">



let form = reactive({
    first_name: '',
    last_name: '',
    email: '',
    password: ''
})

let submit = () => {
    Inertia.post('/users', form)
}

</script>

