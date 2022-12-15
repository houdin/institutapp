<template>

    <!--
      Command palette, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0 scale-95"
        To: "opacity-100 scale-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100 scale-100"
        To: "opacity-0 scale-95"
    -->
    <div
        class="mx-auto transform divide-y divide-gray-500 divide-opacity-20 overflow-hidden rounded-xl shadow-2xl transition-all">
        <div class="relative px-2 mt-1">
            <!-- Heroicon name: outline/magnifying-glass -->
            <svg class="pointer-events-none absolute top-5 left-4 h-7 w-7 text-gray-500"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" ref="inputSearch"
                class="h-14 my-2 w-full pl-12 pr-4 border-gray-500 focus:border-base-200 focus:ring focus:ring-base-200 bg-gray-700 text-gray-100 focus:ring-opacity-20 rounded shadow-sm"
                v-model="form.search" autofocus placeholder="Rechercher...">

            <!-- <JetTextInput id="search" v-model="form.search" type="text"
                class="h-14 mt-1 bg-transparent border-none rounded-lg block w-full pl-14 pr-4"
                placeholder="Rechercher..." required autofocus /> -->
            <!-- <JetTextInput type="text"
                class="h-16 w-full border-0 bg-transparent pl-14 pr-4 placeholder-gray-500 focus:ring-0 sm:text-md"
                placeholder="Rechercher..."> -->
        </div>


        <div id="search-results" class="search-results" v-show="showResults">
            <ul class="_search-results-list flex flex-col">
                <li class="p-0 flex _search-results-item" v-for="(product, index) in searchResults" :key="index">
                    <Link class="_search-result-link p-0 text-lowercase"
                        :href="route('products.show', { slug: product.slug })">
                    <img v-if="product.image" :src="$filters.Image.featuredImageUrl(product.image, 1)" />

                    <span class="_search-result-span"><span class="badge bg-gray-600 text-base-200">{{
                            product.category_id
                    }}</span>
                        <span :id="`_sr_${index}`" class="ms-2">{{ product.title }}</span></span>

                    </Link>
                </li>
            </ul>
        </div>



        <!-- Default state, show/hide based on command palette state. -->
        <ul class="max-h-80 scroll-py-2 divide-y divide-gray-500 divide-opacity-20 overflow-y-auto">
            <li class="p-2">
                <h2 class="mt-4 mb-2 px-3 text-xs font-semibold text-gray-200">Recent searches</h2>
                <ul class="text-sm text-gray-400">
                    <!-- Active: "bg-gray-800 text-white" -->
                    <li class="group flex cursor-default select-none items-center rounded-md px-3 py-2">
                        <!-- Active: "text-white", Not Active: "text-gray-500" -->
                        <!-- Heroicon name: outline/folder -->
                        <svg class="h-6 w-6 flex-none text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        <span class="ml-3 flex-auto truncate">Workflow Inc. / Website Redesign</span>
                        <!-- Not Active: "hidden" -->
                        <span class="ml-3 hidden flex-none text-gray-400">Jump to...</span>
                    </li>
                </ul>
            </li>
            <li class="p-2">
                <h2 class="sr-only">Quick actions</h2>
                <ul class="text-sm text-gray-400">
                    <!-- Active: "bg-gray-800 text-white" -->
                    <li class="group flex cursor-default select-none items-center rounded-md px-3 py-2">
                        <!-- Active: "text-white", Not Active: "text-gray-500" -->
                        <!-- Heroicon name: outline/document-plus -->
                        <svg class="h-6 w-6 flex-none text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span class="ml-3 flex-auto truncate">Add new file...</span>
                        <span class="ml-3 flex-none text-xs font-semibold text-gray-400"><kbd
                                class="font-sans">⌘</kbd><kbd class="font-sans">N</kbd></span>
                    </li>
                    <li class="group flex cursor-default select-none items-center rounded-md px-3 py-2">
                        <!-- Heroicon name: outline/folder-plus -->
                        <svg class="h-6 w-6 flex-none text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        <span class="ml-3 flex-auto truncate">Add new folder...</span>
                        <span class="ml-3 flex-none text-xs font-semibold text-gray-400"><kbd
                                class="font-sans">⌘</kbd><kbd class="font-sans">F</kbd></span>
                    </li>
                    <li class="group flex cursor-default select-none items-center rounded-md px-3 py-2">
                        <!-- Heroicon name: outline/hashtag -->
                        <svg class="h-6 w-6 flex-none text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
                        </svg>
                        <span class="ml-3 flex-auto truncate">Add hashtag...</span>
                        <span class="ml-3 flex-none text-xs font-semibold text-gray-400"><kbd
                                class="font-sans">⌘</kbd><kbd class="font-sans">H</kbd></span>
                    </li>
                    <li class="group flex cursor-default select-none items-center rounded-md px-3 py-2">
                        <!-- Heroicon name: outline/tag -->
                        <svg class="h-6 w-6 flex-none text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                        <span class="ml-3 flex-auto truncate">Add label...</span>
                        <span class="ml-3 flex-none text-xs font-semibold text-gray-400"><kbd
                                class="font-sans">⌘</kbd><kbd class="font-sans">L</kbd></span>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Results, show/hide based on command palette state. -->
        <ul class="max-h-96 overflow-y-auto p-2 text-sm text-gray-400">
            <!-- Active: "bg-gray-800 text-white" -->
            <li class="group flex cursor-default select-none items-center rounded-md px-3 py-2">
                <!-- Active: "text-white", Not Active: "text-gray-500" -->
                <!-- Heroicon name: outline/folder -->
                <svg class="h-6 w-6 flex-none text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                <span class="ml-3 flex-auto truncate">Workflow Inc. / Website Redesign</span>
                <!-- Not Active: "hidden" -->
                <span class="ml-3 hidden flex-none text-gray-400">Jump to...</span>
            </li>
        </ul>

        <!-- Empty state, show/hide based on command palette state. -->
        <div class="py-14 px-6 text-center sm:px-14">
            <!-- Heroicon name: outline/folder -->
            <svg class="mx-auto h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
            </svg>
            <p class="mt-4 text-sm text-gray-200">We couldn't find any projects with that term. Please try
                again.
            </p>
        </div>
    </div>


</template>

<script setup lang="ts">

defineProps({
    classes: String
})

const form = useForm({
    search: '',

});

const inputSearch = ref(null);

onMounted(() => {
    if (inputSearch.value.hasAttribute('autofocus')) {
        inputSearch.value.focus();
    }
});
const showResults = ref(false);
const search = ref("");
const searchResults = ref([]);

const toggleResults = () => {
    if (form.search.length >= 2) {
        showResults.value = true;
        handleSubmit(search.value);
        //console.log("HKgsdlglid");
    } else {
        showResults.value = false;
    }
};


function highlight(text, key) {
    let inputText = document.querySelector("#_sr_" + key);
    let innerHTML = inputText.innerHTML;
    let index = innerHTML.indexOf(text);
    if (index >= 0) {
        innerHTML =
            innerHTML.substring(0, index) +
            "<span class='_hlight color-base-2'>" +
            innerHTML.substring(index, index + text.length) +
            "</span>" +
            innerHTML.substring(index + text.length);
        inputText.innerHTML = innerHTML;
    }
}
const handleSubmit = (val) => {
    //   console.log(values);

    form.post(route('shopping.search.products.api'), {
        onSuccess: async (res) => {
            console.log(res)
            searchResults.value = res.data.products;

            await new Promise((resolve) => {
                setTimeout(resolve, 30);
            });
            const keys = Object.keys(searchResults.value);

            keys.forEach((key) => {
                highlight(search.value, key);
            });
        }, onError: err => {
            console.log(err);
        }
    })

};



// defineExpose({ focus: () => inputSearch.value.focus() });

// watch(form, () => {
//     form.get(route('search'), {
//         onFinish: () => { }, onSuccess: (res) => console.log(res)
//     });
// })
</script>
