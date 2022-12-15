<template>
    <div class="genius-post-item mb55">
        <div class="tab-container">
            <div id="tab1" class="tab-content-1 pt35">
                <div class="best-crs-area best-crs-v2">
                    <div class="row">

                        <div v-for="bundle in bundles" :key="bundle.id" class="col-md-4">
                            <div class="best-crs-pic-text position-relative">
                                <div class="best-crs-pic position-relative"
                                    :style="bundle.image ? 'background-image: url(' + ('storage/uploads/fmts/' + formation.image.name | appasset) : '' + ')'">

                                    <div v-if="bundle.trending == 1" class="trend-badge-2 text-center text-uppercase">
                                        <i class="fas fa-bolt"></i>
                                        <span v-html="trans.get('labels.frontend.badges.trending')"></span>
                                    </div>
                                    <div v-if="bundle.free == 1" class="trend-badge-3 text-center text-uppercase">
                                        <i class="fas fa-bolt"></i>
                                        <span v-html="trans.get('labels.backend.formations.fields.free')"></span>
                                    </div>

                                    <div class="crs-rate ul-li">
                                        <ul>
                                            <li v-for="n in bundle.rating" :key="n"><i class="fas fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <div class="crs-details-btn">
                                        <router-link :to="{ name: 'bundles.show', params: { slug: bundle.slug } }">{{
                                                trans.get('labels.frontend.formation.bundle_detail')
                                        }}
                                            <i class="fas fa-arrow-right"></i>
                                        </router-link>

                                    </div>
                                    <div class="blakish-overlay"></div>
                                </div>
                                <div class="best-crs-text">
                                    <div class="crs-title mb20 headline position-relative">
                                        <h3>
                                            <router-link :to="{ name: 'bundles.show', params: { slug: bundle.slug } }">
                                                {{ bundle.title }}</router-link>
                                        </h3>
                                    </div>
                                    <div class="crs-meta">
                                        <span class="crs-category">
                                            <router-link
                                                :to="{ name: 'formations.category', params: { category: bundle.category.slug } }">
                                                {{ bundle.category.name }}</router-link>
                                        </span>
                                        <span class="crs-author">
                                            <a href="#">{{ bundle.students.length }}
                                                {{ trans.get('labels.frontend.formation.students') }}</a></span>
                                        <span v-if="bundle.formations.length > 1" class="crs-author me-0">{{
                                                bundle.formations.length
                                        }}

                                            {{ trans.get('labels.frontend.formation.formations') }}

                                        </span>
                                        <span v-else class="crs-author me-0">{{ bundle.formations.length }}

                                            {{ trans.get('labels.frontend.formation.formation') }}

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
defineProps({ bundles: Object })
</script>
