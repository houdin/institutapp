<template>
    <nav class="mt-6">
        <ul class="list-disc">
            <li><Link href="/" class="text-blue-500 hover:underline"
            :class="{ 'font-bold underline' : $page.component === 'Home'}">Home</Link>
            </li>
            <li><Link href="/settings" class="text-blue-500 hover:underline"
            :class="{ 'font-bold underline' : $page.component === 'Settings'}">Settings</Link>
            </li>
            <li><Link href="/users" class="text-blue-500 hover:underline"
            :class="{ 'font-bold underline' : $page.component === 'Users'}">Users</Link>
            </li>
            <li><Link href="/logout" method="post" as="button" class="text-blue-500 hover:underline">Log Out</Link></li>
        </ul>
    </nav>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';


</script>
