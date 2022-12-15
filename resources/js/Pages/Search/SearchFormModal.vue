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
        class="relative mx-auto transform divide-y divide-gray-500 divide-opacity-20 overflow-hidden rounded-xl shadow-2xl transition-all">
        <div class="relative px-2 my-1">
            <!-- Heroicon name: outline/magnifying-glass -->
            <form @submit.prevent="handleSubmit">

                <svg class="pointer-events-none absolute top-5 left-4 h-7 w-7 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <!-- <div id="page-loader" class="w-full h-full absolute d-slide-big ">
                    <loader v-show="showLoading"></loader>
                </div> -->
                <input type="text" ref="inputSearch"
                    class="h-14 my-2 w-full pl-12 pr-4 border-gray-500 focus:border-base-200 focus:ring focus:ring-base-200 bg-gray-700 text-gray-100 focus:ring-opacity-20 rounded shadow-sm"
                    v-model="search" autofocus placeholder="Rechercher..." v-on:keyup="toggleResults"
                    autocomplete="off">
            </form>

            <!-- <JetTextInput id="search" v-model="form.search" type="text"
                class="h-14 mt-1 bg-transparent border-none rounded-lg block w-full pl-14 pr-4"
                placeholder="Rechercher..." required autofocus /> -->
            <!-- <JetTextInput type="text"
                class="h-16 w-full border-0 bg-transparent pl-14 pr-4 placeholder-gray-500 focus:ring-0 sm:text-md"
                placeholder="Rechercher..."> -->
        </div>


        <div id="search-results" class="search-results px-2 pt-4" v-show="showResults">
            <ul class="_search-results-list flex flex-col ">
                <li ref="itemRefs" class="py-1 flex _search-results-item hover:bg-gray-700"
                    v-for="(result, index) in searchResults" :key="index">

                    <!-- <Component v-if="result.type" :is="heroIcons[]"
                        class="ml-3 h-6 w-6 flex-shrink-0 text-yellow-500" aria-hidden="true">
                    </Component> -->

                    <Link class="_search-result-link p-0 text-lowercase w-full h-12 px-3" :href="result.url">
                    <!-- <img v-if="result?.searchable.image" :src="$filters.Image.featuredImageUrl(result.searchable.image, 1)" /> -->
                    <div class="_search-result-span flex justify-between w-full h-full items-center">
                        <div class="flex flex-1">
                            <AppHeroIcon :item="result.type" />

                            <span :id="`_sr_${index}`" class="ms-2 ml-4">{{ result.title ? result.title : result.name
                            }}</span>
                        </div>
                        <div class="flex pl-5 space-x-1">
                            <span class="badge bg-gray-700 text-base-300 text-xs">{{
                                    result?.type
                            }}</span>
                            <span v-if="result.searchable.categories"
                                v-for="category in result.searchable.categories.slice(0, 2)" :key="category.id"
                                class="badge bg-gray-700 text-gray-400 text-xs">{{
        category?.name
                                }}</span>
                        </div>
                    </div>

                    </Link>
                </li>
            </ul>
        </div>







    </div>


</template>

<script setup lang="ts">

import * as heroIcons from '@heroicons/vue/24/outline'

defineProps({
    classes: String
})

const modal = inject('modal');


const itemRefs = ref([]);
const search = ref('');
const inputSearch = ref(null);

onMounted(() => {
    if (inputSearch.value.hasAttribute('autofocus')) {
        inputSearch.value.focus();
    }
});

const showLoading = ref(true);

const showResults = ref(false);
const searchResults = ref([]);

watch(itemRefs, (val) => {

})



const toggleResults = () => {
    if (search.value.length >= 2) {
        showResults.value = true;
        handleSubmit(search.value);
        //console.log("HKgsdlglid");
    } else {
        showResults.value = false;
    }
};


const handleSubmit = (val) => {
    //   console.log(values);

    if (val.length >= 2) {
        axios
            .post(route('shopping.search.products.api'), {
                search: val,
            })
            .then(async (response) => {
                console.log(response);
                searchResults.value = response.data.searchResults;

                await new Promise((resolve) => {
                    setTimeout(resolve, 30);
                });
                const keys = Object.keys(searchResults.value);

                keys.forEach((key) => {
                    highlight(search.value, key);
                });

                //   console.log(searchResults.value);
            })
            .catch((error) => {
                console.log(error);
            });
    }
};

function highlight(text, key) {
    let inputText = document.querySelector("#_sr_" + key);
    if (inputText) {
        let innerHTML = inputText.innerHTML;
        let index = innerHTML.indexOf(text);
        if (index >= 0) {
            innerHTML =
                innerHTML.substring(0, index) +
                "<span class='_hlight text-base-200 font-bold'>" +
                innerHTML.substring(index, index + text.length) +
                "</span>" +
                innerHTML.substring(index + text.length);
            inputText.innerHTML = innerHTML;
        }
    }
}

// defineExpose({ focus: () => inputSearch.value.focus() });

// watch(form, () => {
//     form.get(route('search'), {
//         onFinish: () => { }, onSuccess: (res) => console.log(res)
//     });
// })
</script>
