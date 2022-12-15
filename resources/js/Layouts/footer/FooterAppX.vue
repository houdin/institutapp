<template>
    <footer>
        <!-- Newsletter -->
        <div class="relative my-10">
            <div class="absolute left-0 right-0 h-1/2 bg-warm-gray-50" aria-hidden="true"></div>
            <div class="relative mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
                <div
                    class="rounded-3xl bg-gradient-to-l from-gray-800 to-gray-700 border border-gray-500 drop-shadow-lg ">
                    <div class="py-10 px-6 sm:py-8 sm:px-6 lg:flex lg:items-center lg:py-5 lg:px-10 gap-6">

                        <div class="lg:w-0 lg:flex-1">
                            <div class="footer-logo mb25">
                                <Link href="/" class="navbar-brand text-uppercase">
                                <svg class="" width="8.5rem" height="60px">
                                    <use xlink:href="/sprite.svg?logo#logo"></use>
                                </svg>
                                <!-- <img :src="$laravel.urls.index +'/assets/images/logos/'+ $laravel.app.logo_w_image" alt="logo"> -->
                                </Link>
                                <!-- <img :src="`/assets/images/logos/${$page.props.app.logo_w_image}`" alt="logo"> -->
                            </div>

                            <div class="text-xs">
                                <p>FX institut est un studio de création multidimensionnel spécialisé dans les
                                    domaines du design, du
                                    cinéma, des arts visuels et du développement qui dispose d'un programme de
                                    formation en ligne sur
                                    les effets visuels, la post-production et l'animation graphique dirigé par des
                                    professionnels...</p>
                            </div>
                        </div>
                        <div class="lg:w-0 lg:flex-1">
                            <FooterSection v-for="(item, index) in footer_menus" :key="index" :title="item">
                            </FooterSection>
                        </div>
                        <div class="mt-12 sm:w-full sm:max-w-md lg:mt-0 lg:ml-8 lg:flex-1">
                            <div
                                class="footer-menu menu-sociality ms-0 col-lg-3 col-md-6 col-sm-12 flex-grow-1 flex-md-grow-0 flex-shrink-0 flex-md-shrink-1">
                                <div class="footer-social ul-li ">
                                    <h2 class="widget-title">
                                        {{ trans.get('labels.frontend.layouts.partials.social_network') }}</h2>
                                    <ul class="d-flex flex-nowrap justify-content-between">
                                        <li v-for="(item, index) in footer_data.social_links.links" :key="index">
                                            <Link :href="`/${item.link}`"><i :class="item.icon"></i></Link>
                                        </li>

                                    </ul>
                                </div>

                                <div v-if="(footer_data.bottom_footer_links.status === 1 && footer_data.bottom_footer_links.links.length > 0)"
                                    class="menu-policy ul-li mt-4">
                                    <ul>
                                        <li v-for="(item, index) in footer_data.bottom_footer_links.links" :key="index">
                                            <Link :href="`/${item.link}`">{{ item.label }}</Link>
                                            <!-- <a href="{{$item->link}}">{{$item->label}}</a> -->
                                        </li>
                                        <li v-if="$page.props.app.show_offers">
                                            {{ trans.get('labels.frontend.layouts.partials.offers') }}
                                            <!-- <Link :href="route('frontend.offers')">
                                                                                    {{ trans.get('labels.frontend.layouts.partials.offers') }}</Link> -->
                                            <!-- <a href="{{route('frontend.offers')}}">{{ trans.get('labels.frontend.layouts.partials.offers') }}</a>  -->
                                        </li>
                                        <li>
                                            <Link :href="route('frontend.certificates.getVerificationForm')">
                                            {{ trans.get('labels.frontend.layouts.partials.certificate_verification') }}
                                            </Link>
                                            <!-- <a href="{{route('frontend.certificates.getVerificationForm')}}">{{ trans.get('labels.frontend.layouts.partials.certificate_verification') }}</a> -->
                                        </li>
                                    </ul>
                                </div>

                            </div>


                        </div>

                    </div>
                    <div class="flex w-full justify-center  copy-right-menu">

                        <div class="copy-right-text text-sm py-4">
                            <p>Powered By
                                <Link :href="route('frontend.index')" class="text-base-200">FXinstitut</Link> {{
        footer_data.copyright_text.text
                                }}
                            </p>
                            <!-- <p>Powered By <a href="" target="_blank" class="me-4"> FXinstitut</a> Laravel.app.footer_data.copyright_text.text </p> -->
                        </div>

                    </div>
                </div>




            </div>
        </div>

    </footer>
</template>

<script setup lang="ts">

import nav from '@/_nav';

const footer_data = usePage().props.value.app.footer_data;


const footer_menus = nav.footer_menus;

</script>

