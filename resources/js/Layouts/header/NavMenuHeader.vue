<template>
    <header class="sticky top-0 z-30 dark:shadow-none dark:bg-transparent transition duration-500 ease-in-out"
        :class="{ ' -translate-y-14': hideNavbar }">
        <Popover class="relative bg-slate-900 shadow" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
                <div class="relative flex h-14 items-center justify-between">
                    <div class="flex items-center px-2 lg:px-0">
                        <div class="flex-shrink-0">
                            <logo-header></logo-header>
                        </div>


                        <PopoverGroup as="nav" class="hidden lg:ml-6 lg:block">
                            <div class="flex">
                                <template v-for="item in menus">
                                    <Popover v-if="item.submenu" class="relative" v-slot="{ open }">
                                        <PopoverButton as="a" href="#"
                                            :class="[open ? 'text-yellow-500' : 'text-gray-300', 'flex rounded-md pl-3 py-2 text-xs font-medium tracking-wide  hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-1 focus:ring-inset focus:ring-gray-500']">
                                            <span>{{ item.name.toUpperCase() }}</span>

                                            <ChevronDownIcon
                                                :class="[open ? 'text-yellow-500' : 'text-gray-300', 'mr-2 h-5 w-5 group-hover:text-yellow-500']"
                                                aria-hidden="true" />
                                        </PopoverButton>

                                        <transition enter-active-class="transition ease-out duration-200"
                                            enter-from-class="opacity-0 translate-y-1"
                                            enter-to-class="opacity-100 translate-y-0"
                                            leave-active-class="transition ease-in duration-150"
                                            leave-from-class="opacity-100 translate-y-0"
                                            leave-to-class="opacity-0 translate-y-1">
                                            <PopoverPanel
                                                class="absolute z-10 -ml-4 mt-3 w-screen max-w-md transform px-2 sm:px-0 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2">
                                                <div
                                                    class="overflow-hidden rounded-lg bg-gray-900 border border-gray-800 shadow-lg ring-1 ring-black ring-opacity-5">
                                                    <div class="relative grid gap-3 px-5 py-3 sm:gap-5 sm:p-5">
                                                        <template v-for="(subitem, name) in item.submenu">
                                                            <Link v-if="name !== 'callToAction'"
                                                                :href="'/' + subitem.href"
                                                                class="-m-3 flex items-start rounded-lg p-3 hover:bg-gray-50">

                                                            <Component :is="heroIcons[subitem.icon + 'Icon']"
                                                                class="h-6 w-6 flex-shrink-0 text-yellow-500"
                                                                aria-hidden="true"></Component>

                                                            <div class="ml-4">
                                                                <p
                                                                    class="text-xs tracking-wider font-medium text-gray-300">
                                                                    {{
                                                                            name.toUpperCase()
                                                                    }}</p>
                                                                <!-- <p class="mt-1 text-sm text-gray-500">{{
                                                                        subitem.description
                                                                }}
                                                                </p> -->
                                                            </div>
                                                            </Link>
                                                        </template>
                                                    </div>
                                                    <div v-if="item.submenu['callToAction']"
                                                        class="space-y-6 bg-gray-700 px-5 py-5 sm:flex sm:space-y-0 sm:space-x-10 sm:px-8">
                                                        <template
                                                            v-for="(subitem, name) in item.submenu['callToAction']">
                                                            <div class="flow-root">
                                                                <Link :href="'/' + subitem.href"
                                                                    class="-m-3 flex items-center rounded-md p-3 text-xs font-medium text-gray-300 hover:bg-gray-100">
                                                                <component :is="heroIcons[subitem.icon + 'Icon']"
                                                                    class="h-6 w-6 flex-shrink-0 text-gray-400"
                                                                    aria-hidden="true" />
                                                                <span class="ml-3">{{ name.toUpperCase() }}</span>
                                                                </Link>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </PopoverPanel>
                                        </transition>
                                    </Popover>
                                    <Link v-else :href="'/' + item.href"
                                        class="flex rounded-md p-3 py-2 text-xs text-gray-300 font-medium tracking-wide  hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-1 focus:ring-inset focus:ring-gray-500">
                                    {{ item.name.toUpperCase() }}</Link>
                                </template>


                            </div>
                        </PopoverGroup>
                    </div>
                    <div class="flex flex-1 justify-center px-2 lg:ml-6 lg:justify-end">
                        <div class="w-full max-w-lg lg:max-w-xs">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                </div>
                                <input id="search" name="search"
                                    class="block w-full rounded-md border border-transparent bg-gray-700 py-2 pl-10 pr-3 leading-5 text-gray-300 placeholder-gray-400 focus:border-white focus:bg-white focus:text-gray-900 focus:outline-none focus:ring-white sm:text-sm"
                                    placeholder="Search" type="search" />
                            </div>
                        </div>
                    </div>
                    <div class="flex lg:hidden">
                        <!-- Mobile menu button -->
                        <PopoverButton
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Open menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </PopoverButton>
                    </div>
                    <div class="hidden lg:ml-4 lg:block">
                        <div class="flex items-center">
                            <button type="button"
                                class="flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="h-6 w-6" aria-hidden="true" />
                            </button>

                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-4 flex-shrink-0">
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
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Your
                                            Profile</a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Settings</a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <a href="#"
                                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Sign
                                            out</a>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                </div>
            </div>


            <PopoverPanel focus class="lg:hidden">
                <div class="divide-y-2 divide-gray-50 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="px-5 pt-5 pb-6">
                        <div class="mt-6">
                            <div class="space-y-1 px-2 pt-2 pb-3">
                                <a v-for="item in features" :key="item.name" :href="item.href"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                                    <component :is="item.icon" class="h-6 w-6 flex-shrink-0 text-indigo-600"
                                        aria-hidden="true" />
                                    <span class="ml-3 text-base font-medium text-gray-900">{{ item.name }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6 py-6 px-5">
                        <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                            <a href="#"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pricing</a>

                            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Docs</a>
                            <a v-for="item in resources" :key="item.name" :href="item.href"
                                class="text-base font-medium text-gray-900 hover:text-gray-700">{{ item.name }}</a>
                        </div>
                        <div>
                            <a href="#"
                                class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Sign
                                up</a>
                            <p class="mt-6 text-center text-base font-medium text-gray-500">
                                Existing customer?
                                <a href="#" class="text-indigo-600 hover:text-indigo-500">Sign in</a>
                            </p>
                        </div>
                    </div>
                </div>
            </PopoverPanel>


        </Popover>
    </header>

    <!-- <search-wrapper class="d-flex"></search-wrapper> -->



</template>

<script setup lang="ts">

import { Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue'

import {
    PhoneIcon,
    PhotoIcon


} from '@heroicons/vue/24/outline'
import * as heroIcons from "@heroicons/vue/24/outline";

import {
    ArrowPathIcon,
    BookmarkSquareIcon,
    CalendarIcon,

    CursorArrowRaysIcon,
    LifebuoyIcon,

    PlayIcon,
    ShieldCheckIcon,
    Squares2X2Icon,
    Bars3Icon, BellIcon, XMarkIcon
} from '@heroicons/vue/24/outline'
import { ChevronDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'


const navigation = [
    { name: 'Product', href: '#' },
    { name: 'Features', href: '#' },
    { name: 'Marketplace', href: '#' },
    { name: 'Company', href: '#' },
]



const features = [
    {
        name: 'Gallery',
        href: '#',
        description: 'Get a better understanding of where your traffic is coming from.',
        icon: PhotoIcon,
    },
    {
        name: 'Engagement',
        href: '#',
        description: 'Speak directly to your customers in a more meaningful way.',
        icon: CursorArrowRaysIcon,
    },
    { name: 'Security', href: '#', description: "Your customers' data will be safe and secure.", icon: ShieldCheckIcon },
    {
        name: 'Integrations',
        href: '#',
        description: "Connect with third-party tools that you're already using.",
        icon: Squares2X2Icon,
    },
    {
        name: 'Automations',
        href: '#',
        description: 'Build strategic funnels that will drive your customers to convert',
        icon: ArrowPathIcon,
    },
]
const callsToAction = [
    { name: 'Watch Demo', href: '#', icon: PlayIcon },
    { name: 'Contact Sales', href: '#', icon: PhoneIcon },
]
const resources = [
    {
        name: 'Help Center',
        description: 'Get all of your questions answered in our forums or contact support.',
        href: '#',
        icon: LifebuoyIcon,
    },
    {
        name: 'Guides',
        description: 'Learn how to maximize our platform to get the most out of it.',
        href: '#',
        icon: BookmarkSquareIcon,
    },
    {
        name: 'Events',
        description: 'See what meet-ups and other events we might be planning near you.',
        href: '#',
        icon: CalendarIcon,
    },
    { name: 'Security', description: 'Understand how we take your privacy seriously.', href: '#', icon: ShieldCheckIcon },
]
const recentPosts = [
    { id: 1, name: 'Boost your conversion rate', href: '#' },
    { id: 2, name: 'How to use search engine optimization to drive traffic to your site', href: '#' },
    { id: 3, name: 'Improve your customer experience', href: '#' },
]



const menus = usePage().props.value.app.main_menu;


const hideNavbar = ref(false);
const lastScrollPosition = ref(0);

const limitPosition = 100;
const scrolled = ref(false);
const lastPosition = ref(0);




const isActive = (group, path) => {
    const path_sub = path.substr(1);
    //   console.log(menus.studio);
    if (menus[group.toLowerCase()]) {
        return menus[group.toLowerCase()].indexOf(path_sub) >= 0;
    }
    return false;
};



const onScroll = () => {
    // if (
    //     !document
    //         .querySelector("#search-wrapper")
    //         .classList.contains("search--hidden")
    // ) {
    //     Event.$emit("search-toggle", true);
    // }
    // Get the current scroll position
    const currentScrollPosition =
        window.pageYOffset || document.documentElement.scrollTop;
    // Because of momentum scrolling on mobiles, we shouldn't continue if it is less than zero
    if (currentScrollPosition < 0) {
        return;
    }
    if (Math.abs(currentScrollPosition - lastScrollPosition.value) < 50) {
        return;
    }
    // Here we determine whether we need to show or hide the navbar
    hideNavbar.value = currentScrollPosition > lastScrollPosition.value;

    // hideNavbar.value ? $("#mobile-menu").removeClass("show") : null;
    // Set the current scroll position as the last scroll position
    lastScrollPosition.value = currentScrollPosition;
};

document.addEventListener("scroll", () => onScroll());


</script>

