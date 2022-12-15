<template>
    <footer
        class="footer mx-auto mt-10 p-10 max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8 rounded-3xl bg-gradient-to-l from-gray-800 to-gray-700 border border-gray-500 drop-shadow-lg text-base-content">
        <div>
            <Link href="/" class="navbar-brand text-uppercase">
            <svg class="" width="8.5rem" height="45px">
                <use xlink:href="/sprite.svg?logo#logo"></use>
            </svg>
            <!-- <img :src="$laravel.urls.index +'/assets/images/logos/'+ $laravel.app.logo_w_image" alt="logo"> -->
            </Link>

            <p>FX institut est un studio de création multidimensionnel<br /> spécialisé dans les
                domaines du design, du
                cinéma,<br /> des arts visuels et du développement qui dispose d'un<br /> programme de
                formation en ligne sur
                les effets visuels,<br /> la post-production et l'animation graphique dirigé par<br /> des
                professionnels...</p>
        </div>
        <div class="footer-center">
            <span class="footer-title">Services</span>
            <a class="link link-hover">Branding</a>
            <a class="link link-hover">Design</a>
            <a class="link link-hover">Marketing</a>
            <a class="link link-hover">Advertisement</a>
        </div>
        <div class="footer-center">
            <span class="footer-title">Services</span>
            <a class="link link-hover">Branding</a>
            <a class="link link-hover">Design</a>
            <a class="link link-hover">Marketing</a>
            <a class="link link-hover">Advertisement</a>
        </div>
        <div class="footer-center">
            <span class="footer-title">Company</span>
            <a class="link link-hover">About us</a>
            <a class="link link-hover">Contact</a>
            <a class="link link-hover">Jobs</a>
            <a class="link link-hover">Press kit</a>
        </div>
        <div class="footer-center">
            <span class="footer-title">Social</span>
            <div class="grid grid-flow-col gap-4">
                <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="fill-current">
                        <path
                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z">
                        </path>
                    </svg></a>
                <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="fill-current">
                        <path
                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                        </path>
                    </svg></a>
                <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="fill-current">
                        <path
                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                        </path>
                    </svg></a>
            </div>
        </div>




    </footer>
    <div class="flex justify-center px-10 mt-10 py-4 border-t text-sm border-gray-700">
        <div class="flex items-center">
            <svg class="opacity-60" width="4rem" height="30px">
                <use xlink:href="/sprite.svg?logo#logo-icon"></use>
            </svg>

            <p>Copyright © 2022 - All right reserved</p>
        </div>

    </div>
</template>

<script setup lang="ts">

import nav from '@/modules/_nav';

const footer_data = usePage().props.value.app.footer_data;


const footer_menus = nav.footer_menus;

</script>

