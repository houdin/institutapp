<template>
    <div class="group card w-96 bg-gray-800 shadow-xl relative overflow-hidden">
        <figure v-if="formation.image">
            <div class="relative">
                <img class="transition group-hover:scale-110" :src="$helpers.Image.featuredImageUrl(formation.image, 5)"
                    alt="Shoes" />
                <div
                    class="bg-black transition-opacity opacity-0 group-hover:opacity-60 backdrop-blur-sm absolute w-full h-full top-0">
                </div>
                <div
                    class="crs-details-btn transition duration-500 absolute opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-20  right-5 bottom-4">

                    <Link :href="$route('formations.show', { slug: formation.slug })" class="flex items-center">
                    <span class="text-sm font-bold">{{ trans.get('labels.frontend.formation.formation_detail') }}</span>
                    <AppHeroIcon icon="ArrowSmallRightIcon" solid size="h-4 w-4" />
                    </Link>

                </div>

            </div>
        </figure>
        <!-- <div v-if="formation.free==1" class="trend-badge-3 text-center text-uppercase">
                <i class="fas fa-bolt"></i>
                <span v-html="trans.get('labels.backend.formations.fields.free')"></span>
              </div> -->
        <div class="crs-price text-center gradient-bg">

            <!-- <span v-if="formation.free == 1" v-html="trans.get('labels.backend.formations.fields.free')"></span> -->

            <!-- <span v-else> {{ $page.props.app.appCurrency + ' ' + formation.price }}</span> -->

        </div>
        <!-- <div class="crs-rate ul-li">
            <ul class="flex">

                <li v-for="index in Math.round(formation.rating)" :key="index">
                    <AppHeroIcon icon="StarIcon" solid size="h-4 w-4" />
                </li>

            </ul>
        </div> -->


        <div class="card-body">
            <h2 class="card-title">
                <Link :href="$route('formations.show', { slug: formation.slug })">{{ formation.title }}
                </Link>
                <div class="badge badge-secondary">NEW</div>
            </h2>
            <div class="card__bar"></div>
            <p class="card-text">{{ $helpers.Text.truncate(formation.description, 130) }}</p>
            <!-- <add-cart-icon :product-id="formation.id" type="formation" cartText>

                        </add-cart-icon> -->
            <!-- <p>If a dog chews shoes whose shoes does he choose?</p> -->
            <div class="card-actions justify-end">
                <div class="badge badge-outline">Fashion</div>
                <div class="badge badge-outline">Products</div>
            </div>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>


</template>

<script setup lang="ts">
const props = defineProps({
    formation: Object,
});
</script>
