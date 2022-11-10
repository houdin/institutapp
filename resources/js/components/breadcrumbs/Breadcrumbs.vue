<template>

    <div class="breadcrumb-section background-style">
        <!-- <div class="blakish-overlay"></div> -->

        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol id="breadcrumb" class="breadcrumb">
                    <template v-for="(item, index) in breadCrumbs">
                        <li v-if="item.to" :key="index" class="breadcrumb-item">
                            <router-link @click="nextEmit" :to="{name: item.to.name}" class="breadcrumb-item">{{
                            item.text}}</router-link>
                        </li>
                        <li v-if="(index < 1) && prevRoute && (prevRoute.params.category || prevRoute.params.tag)"
                            class="breadcrumb-item">
                            <router-link @click="nextEmit" :to="{name: prevRoute.name , params: prevRoute.params}"
                                class="breadcrumb-item">{{ prevRoute.params.category ? prevRoute.params.category :
                                prevRoute.params.tag}}</router-link>
                        </li>
                        <li v-if="!item.to" class="breadcrumb-item active" aria-current="page">
                            {{ item.text.split('-').join(' ') }}
                        </li>

                    </template>

                    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Library</li> -->
                </ol>
            </nav>
            <!-- <div class="page-breadcrumb-content text-center"> -->

            <!-- <div class="page-breadcrumb-title">
                        <h2 class="breadcrumb-head black bold">
                            <span>


                            </span>
                        </h2>
                    </div> -->
        </div>

    </div>

</template>
<script setup>
const { computed, ref } = require("@vue/reactivity");
const { onMounted, inject, onUpdated, watch } = require("@vue/runtime-core");
const { useRoute, useRouter } = require("vue-router");

const route = useRoute();
const router = useRouter();
const routeRef = computed(() => {
    return { name: route.name, path: route.path, params: route.params };
});

const prevRoute = ref(null);

const $filters = inject("$filters");
const breadCrumbs = computed(() => {
    if (typeof route.meta.breadCrumb === "function") {
        return route.meta.breadCrumb.call(this, route);
    }

    return route.meta.breadCrumb;
});
const emit = defineEmits(["prevBread"]);

const nextEmit = () => {
    emit("prevBread", true);
};

onMounted(() => { });

watch(routeRef, (currentRoute, prev) => {
    prevRoute.value = prev;
});

onUpdated(() => { });
</script>
