<template>
    <nav class="">
        <ul class="flex list-disc space-x-4 list-inside">
            <li class="text-white">
                <NavLink href="/" :active="$page.component === 'Home'"> Home</NavLink>
            </li>
            <li>
                <NavLink href="/settings" :active="$page.component === 'Settings'"> Settings</NavLink>
            </li>
            <li>
                <NavLink href="/users" :active="$page.component === 'Users'"> Users</NavLink>
            </li>
        </ul>
    </nav>
</template>

<script setup lang="ts">


</script>
