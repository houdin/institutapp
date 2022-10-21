<template>
    <!-- <home-slider @in-progress="progressBar"></home-slider> -->
    <hero-section></hero-section>

    <latest-data></latest-data>

    <gallery-home></gallery-home>

    <premium-home></premium-home>

    <!-- <faq-home></faq-home> -->
</template>

<script setup>
import { useMeta } from "vue-meta";
useMeta({ title: "FXinstitut.com", description: "FXinstitut.com" });

const {
    inject,
    ref,
    onMounted,
    onBeforeMount,
    provide,
} = require("@vue/runtime-core");

const homeData = ref([]);

onBeforeMount(async () => {
    await getHome();
    await getApiFormations();
});

onMounted(() => { });

provide("homeData", homeData);
/////
const slides = ref({});
const product = ref({});
const downloads = ref({});

const getHome = async () => {
    try {
        const response = await axios.post(Laravel.urls.home_data);
        homeData.value = response.data;
    } catch (err) { }
};
// const getApiFormations = async () => {
//   try {
//     const response = await axios.post("/api/v1/formations", {
//       type: "popular",
//     });
//     console.log(response.data);
//   } catch (err) {}
// };
</script>
