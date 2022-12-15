<template>
    <div class="hidden lg:ml-4 lg:block">
        <div v-if="$page.props.app.user" class="flex items-center">
            <button type="button"
                class="flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                <span class="sr-only">View notifications</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button>

            <UserMenuNav></UserMenuNav>

            <!-- Profile dropdown -->
            <!-- <Menu as="div" class="relative ml-4 flex-shrink-0">
                <div>
                    <MenuButton
                        class="flex rounded-full bg-gray-800 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full"
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="" />
                    </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <MenuItem v-slot="{ active }">
                        <Link :href="route()" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Your
                            Profile</Link>
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                        <a href="#"
                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Settings</a>
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                        <Link :href="route('logout')" method="POST"
                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Sign
                        out</Link>
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu> -->
        </div>
        <div v-else class="flex items-center">
            <!-- <button type="button" >Modal</button> -->
            <span @click="modalOpener" class="text-sm uppercase cursor-pointer font-bold hover:text-base-200">Se
                Connecter
            </span>

            <AuthModal v-if="!$page.props.app.user && modal.type === 'auth'" :outside="true" />
            <!-- <RegisterModal v-if="modalType === 'register'" :outside="true" /> -->

        </div>
    </div>


</template>

<script setup lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';

import {
    BellIcon
} from '@heroicons/vue/24/outline'

const modal = inject('modal');




const modalOpener = () => {
    modal.auth()
}


</script>

