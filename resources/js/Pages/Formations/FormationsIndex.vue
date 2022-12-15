<template>

    <!-- Start of formation section
            ============================================= -->
    <!-- <search-formations></search-formations> -->
    <div class="">

        <div class="grid md:grid-cols-3 grid-cols-1 gap-4">

            <template v-if="formations.data[0]">

                <div v-for="(item, index) in formations.data" :key="index" class="flex flex-col ">

                    <formations-item @add-to-cart="addToCart" :formation="item"></formations-item>

                </div>

            </template>

            <h3 v-else>Pas de Formation Disponible !</h3>

            <!-- /formation -->

            <!-- <div class="couse-pagination text-center ul-li"> -->
            <!-- <pagination v-model="page" :records="last_page" :per-page="1" @paginate="getFormations" /> -->
            <!-- <pagination :data="formations" @pagination-change-page="getResults"></pagination>  -->

        </div>
        <Pagination :links="formations.links" />
    </div>

    <!-- End of formation section
        ============================================= -->
</template>

<script setup lang="ts">


const postData = ref("");
const formationsData = ref([]);
// const page = ref(1);
const last_page = ref(1);
const no_formation = ref(false);

const breadcrumbs = inject('breadcrumbs');


onMounted(() => {
    breadcrumbs.value = [
        {
            name: "Formations",
        }
    ]
})


let props = defineProps({
    formations: Object,
    filters: Object
})

let search = ref(props.filters.s);

watch(search, value => {
    Inertia.get('/formations', { s: value }, { preserveState: true, replace: true })
})

/**
 * ajax request to update the current cart
 * @return {void}
 */
const updateCart = (value) => {
    postData.value = value;
    ajaxPostRequest(Laravel.urls.shopping_cart_update);
};

const ajaxPostRequest = (url) => {
    axios
        .post(url, postData.value)
        .then((response) => {
            updateMessage(response.data);
            store
                .dispatch("Cart/getCart")
                .then(() => { })
                .catch((error) => console.error(error));
        })
        .catch((error) => {
            updateError(error);
        });
};
/**
 * gets the post data from the child classes and sets the postData property
 * then it calls the ajax post request method to add to send the data to the
 * server
 * @param {value} post data sent from child class
 * @return {void}
 */
const addToCart = (value) => {
    postData.value = value;
    ajaxPostRequest(Laravel.urls.shopping_cart_add);
};

const updateMessage = (data) => {
    cart.value = data.cart;
    Event.$emit("update-user-message", data.message);
};

const updateError = () => {
    console.log(error);
};
</script>

