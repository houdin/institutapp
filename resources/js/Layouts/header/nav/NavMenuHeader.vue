<template>
    <header id="header" :class="{ ' -translate-y-14': hideNavbar }"
        class="sticky top-0 z-50 bg-gray-800 drop-shadow-lg transition duration-500 ease-in-out">

        <div class="container relative h-14 mx-auto">
            <div class="relative h-full flex items-center justify-between px-4 sm:px-6 md:justify-start md:space-x-10">
                <div class="flex-shrink-0">
                    <logo-header></logo-header>
                </div>
                <div class="-my-2 -mr-2 md:hidden">
                    <button v-if="!open" type="button"
                        class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-300 hover:bg-gray-900 hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-base-200"
                        aria-expanded="false" @click="open = true">
                        <span class="sr-only">Open menu</span>
                        <AppHeroIcon icon="Bars3Icon" size="w-6 h-6" />
                    </button>
                    <button v-else type="button" @click="open = false"
                        class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-300 hover:bg-gray-900 hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-base-200">
                        <span class="sr-only">Close menu</span>
                        <AppHeroIcon icon="XMarkIcon" />
                    </button>
                </div>
                <div :class="{ 'hidden': !open }"
                    class="inset-x-0 max-md:absolute top-14 md:top-0 p-2 transition md:flex md:flex-1 md:items-center md:justify-between h-full">

                    <nav ref="navmenu" id="navmenu"
                        class="flex flex-col bg-gray-800 md:bg-none md:flex-row items-center md:h-full"
                        :data-target="navmenuTarget" :data-open="navmenuOpen" :data-lock="navmenuLock">


                        <div ref="itemRefs" v-for="(item, index) in menus">
                            <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                            <div ref="menuItemsElement" v-class-hover="index"
                                :class="[state.hover == index ? 'text-yellow-500' : 'text-gray-300', 'flex group rounded-md px-2 pl-3 py-2 text-xs font-medium tracking-wide  hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-1 focus:ring-inset focus:ring-gray-500']"
                                aria-expanded="false" :data-target="`#dropdown${index + 1}`">
                                <template v-if="item.submenu">
                                    <span>{{ item.name.toUpperCase() }}</span>
                                    <!--
                      Item active: "text-gray-600", Item inactive: "text-gray-400"
                    -->
                                    <AppHeroIcon icon="ChevronDownIcon" size="w-3 h-4"
                                        class="ml-1 group-hover:text-yellow-500"
                                        :color="`${state.hover == index ? 'text-yellow-500' : 'text-gray-300'}`" />
                                </template>
                                <Link v-else :href="item?.href"
                                    class="text-base font-semibold text-gray-500 hover:text-gray-900">{{
                                            item.name.toUpperCase()
                                    }}
                                </Link>
                            </div>

                            <template v-if="item.submenu">
                                <div ref="submenuItemsElement" :id="`dropdown${index + 1}`"
                                    class="hidden transition relative md:absolute __dropdown top-0 md:top-14 inset-x-0 z-10 transform"
                                    v-class-leave>
                                    <div class="container mx-auto">

                                        <div
                                            class=" rounded-lg shadow-lg bg-gray-900 border border-gray-800 ring-1 ring-black ring-opacity-5">
                                            <div
                                                class="mx-auto grid max-w-7xl gap-y-4 px-4 py-6 grid-cols-1 md:grid-cols-2 sm:gap-4 sm:px-3 sm:py-6 lg:grid-cols-3 xl:grid-cols-4 lg:px-8 lg:py-8 xl:py-8">
                                                <template v-for="(subitem, name) in item.submenu">
                                                    <Link v-if="name !== 'callToAction'" :href="'/' + subitem.href"
                                                        class="-m-2 flex justify-between rounded-md p-2 transition duration-150 ease-in-out hover:bg-gray-700">
                                                    <div
                                                        class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-md text-white sm:h-12 sm:w-6">
                                                        <AppHeroIcon :item="subitem.href" />
                                                    </div>
                                                    <div class="ml-4 flex flex-col">
                                                        <p class="text-sm font-semibold text-gray-200">{{
                                                                name.toUpperCase()
                                                        }}</p>
                                                        <p class="hidden md:block mt-1 text-xs text-gray-400">Get a
                                                            better
                                                            understanding
                                                            of
                                                            where your
                                                            traffic is coming from.</p>
                                                    </div>
                                                    </Link>
                                                </template>


                                            </div>

                                            <div v-if="item.submenu['callToAction']" class="bg-gray-800 rounded-b-lg">
                                                <div
                                                    class="mx-auto max-w-7xl space-y-6 px-4 py-5 sm:flex sm:space-y-0 sm:space-x-10 sm:px-6 lg:px-8">
                                                    <template v-for="(subitem, name) in item.submenu['callToAction']">
                                                        <div class="flow-root">
                                                            <Link :href="'/' + subitem.href"
                                                                class="-m-3 flex items-center rounded-md p-3 text-sm font-semibold text-gray-300 transition duration-150 ease-in-out hover:bg-gray-900">
                                                            <AppHeroIcon :item="subitem.href" />
                                                            <span class="ml-3">{{
                                                                    name.toUpperCase()
                                                            }}</span>
                                                            </Link>

                                                        </div>
                                                    </template>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </template>
                        </div>


                    </nav>
                    <!-- Right Menu -->
                </div>
                <div class="flex flex-1 justify-center px-2 lg:ml-6 lg:justify-end">
                    <div class="w-full max-w-lg lg:max-w-[200px]">
                        <SearchHeader></SearchHeader>
                        <!-- <navbar-cart>

                                                </navbar-cart> -->


                        <!-- <label for="search" class="sr-only">Rechercher</label>
                                                <div class="relative">
                                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                        <MagnifyingGlassIcon class="h-5 w-5 text-base-200" aria-hidden="true" />
                                                    </div>
                                                    <input id="search" name="search" @click="openModal = true"
                                                        class="block w-full rounded-md border border-transparent bg-gray-700 py-2 pl-10 pr-3 leading-5 text-gray-300 placeholder-gray-400 focus:border-white focus:bg-white focus:text-gray-900 focus:outline-none focus:ring-white sm:text-sm"
                                                        placeholder="Rechercher" type="search" />
                                                </div> -->
                    </div>
                </div>
                <NavbarMenuUser />
            </div>


            <!--
            Mobile menu, show/hide based on mobile menu state.

            Entering: "duration-200 ease-out"
              From: "opacity-0 scale-95"
              To: "opacity-100 scale-100"
            Leaving: "duration-100 ease-in"
              From: "opacity-100 scale-100"
              To: "opacity-0 scale-95"
          -->
            <!-- <div class="absolute inset-x-0 top-0 origin-top-right transform p-2 transition md:hidden">
                <div class="divide-y-2 divide-gray-50 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="px-5 pt-5 pb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-shrink-0">
                                <logo-header />
                            </div>
                            <div class="-mr-2">
                                <button type="button"
                                    class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-300 hover:bg-gray-900 hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-base-200">
                                    <span class="sr-only">Close menu</span>
                                    <AppHeroIcon icon="XMarkIcon" />
                                </button>
                            </div>
                        </div>
                        <div class="mt-6">
                            <nav class="grid gap-6">
                                <Link href="#" class="-m-3 flex items-center rounded-lg p-3 hover:bg-gray-50">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-md bg-indigo-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4 text-base font-medium text-gray-900">Analytics</div>
                                </Link>


                            </nav>
                        </div>
                    </div>
                    <div class="py-6 px-5">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Pricing</a>

                            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Docs</a>

                            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Enterprise</a>

                            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Help Center</a>

                            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Guides</a>

                            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Events</a>

                            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Security</a>
                        </div>
                        <div class="mt-6">
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
            </div> -->
        </div>


        <!-- <search-wrapper class="d-flex"></search-wrapper> -->

    </header>

</template>

<script setup lang="ts">

import NavItems from '@/modules/_nav';

const menus = NavItems.main_menu;

const state = ref({
    hover: -1
})

const hideNavbar = inject('hideNavbar');
const lastScrollPosition = ref(0);

const limitPosition = 100;
const scrolled = ref(false);
const lastPosition = ref(0);

const open = ref(false)
const menuItemsElement = ref([]);
const submenuItemsElement = ref([]);
const itemRefs = ref([]);

const menuEnter = ['ease-out', 'duration-200', 'opacity-100', 'translate-y-1', '__menuEnter'];
const menuLeave = ['ease-in', 'duration-150', 'opacity-0', 'translate-y-0', '__menuLeave'];

const displayClass = '!block';

const navmenu = ref(null);
const navmenuTarget = ref('');
const navmenuOpen = ref('0');
const navmenuLock = ref('0');

const prevEvent = ref<MouseEvent>();
const currentEvent = ref<MouseEvent>();
const mouseMouvementX = ref(0);
const mouseMouvementY = ref(0);
const speed = ref(0);
const prevSpeed = ref(0);

/// WATCH MOUSE MOUVEMENT
document.documentElement.onmousemove = (event) => {
    currentEvent.value = event
}
watch(currentEvent, async (val, prev) => {
    await Helpers.Utility.timeOut(50)
    if (currentEvent.value && prevEvent.value) {
        mouseMouvementX.value = Math.abs(currentEvent.value.screenX - prevEvent.value.screenX)
        mouseMouvementY.value = Math.abs(currentEvent.value.screenY - prevEvent.value.screenY)
        let mouvement = Math.round(Math.sqrt(mouseMouvementX.value * mouseMouvementX.value + mouseMouvementY.value * mouseMouvementY.value));
        speed.value = 10 * mouvement;
    }
    prevEvent.value = currentEvent.value;
})
watch(speed, async (current, prev) => {
    prevSpeed.value = prev
})
/// END WATCH MOUSE MOUVEMENT


const isActive = (group, path) => {
    const path_sub = path.substr(1);
    //   console.log(menus.studio);
    if (menus[group.toLowerCase()]) {
        return menus[group.toLowerCase()].indexOf(path_sub) >= 0;
    }
    return false;
};

const vClassHover = {
    mounted(el, binding) {

        el.addEventListener('mouseenter', async (event) => {
            // if (speed.value <= 10) {
            state.value.hover = binding.value;
            await navMenuCloser();
            const target = el.dataset.target;
            navmenuTarget.value = target
            await navMenuOpener(target);
            // }

        })

    },
}
const vClassLeave = {
    mounted(el, binding) {
        el.addEventListener('mouseleave', async (event) => {
            DOMTokenList.prototype.remove.apply(el.classList, menuEnter);
            DOMTokenList.prototype.add.apply(el.classList, menuLeave);

            await Helpers.Utility.timeOut(150)
            el.classList.remove(displayClass);
            navmenuTarget.value = '';
            navmenuOpen.value = '0';
            await Helpers.Utility.timeOut(100)
        })

    },
}


// watch([navmenuTarget, navmenuOpen], async ([target, open]) => {
//     // if (prev.length) {
//     await navMenuCloser();
//     // const targetEl = target ? document.querySelector(target) : null;
//     if (target && prevSpeed.value <= 80) await navMenuOpener(target)
//     // }
// })

onMounted(() => {
    menuItemsElement.value.forEach(el => {
        el.addEventListener('click', async (event) => {
            await navMenuCloser();
            navmenuLock.value = '1';
            await navMenuOpener(el.dataset.target)
        })
    });

    document.addEventListener('click', async (event) => {
        if (navmenuLock.value === '1' || navmenuOpen.value === '1') {
            if (!(navmenu.value.contains(event.target))) {
                await navMenuCloser();
                navmenuTarget.value = '';
                navmenuOpen.value = '0';
                navmenuLock.value = '0';
                // return false
            }

        }

    })
})

Inertia.on('start', async (event) => {
    await navMenuCloser();
    navmenuTarget.value = '';
    navmenuOpen.value = '0';
    navmenuLock.value = '0';
})

const onScroll = async () => {
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
    if (hideNavbar.value) await navMenuCloser()

    // hideNavbar.value ? $("#mobile-menu").removeClass("show") : null;
    // Set the current scroll position as the last scroll position
    lastScrollPosition.value = currentScrollPosition;
};

document.addEventListener("scroll", () => onScroll());



async function navMenuCloser(leave?: boolean, tester?: string) {
    submenuItemsElement.value.every(async (el) => {
        if (el.classList.contains('ease-out')) {

            DOMTokenList.prototype.remove.apply(el.classList, menuEnter);
            DOMTokenList.prototype.add.apply(el.classList, menuLeave);

            await Helpers.Utility.timeOut(150)
            el.classList.remove(displayClass);
            navmenuTarget.value = '';
            navmenuOpen.value = '0';

            return false;
        }
    })
    await Helpers.Utility.timeOut(150)

}

async function navMenuOpener(data: string) {
    if (data) {
        const target = document.querySelector(data);
        if (target) {
            target.classList.add(displayClass);
            await Helpers.Utility.timeOut(50);
            // DOMTokenList.prototype.remove.apply(target?.classList, menuLeave);
            DOMTokenList.prototype.add.apply(target?.classList, menuEnter);
            await Helpers.Utility.timeOut(200)
        }
    }
}



</script>

