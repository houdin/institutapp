<template>
  <footer>
    <section id="footer-area" class="footer-area-section">
      <div class="container">
        <div class="footer-content">
          <div class="row flex-wrap flex-lg-nowrap">
            <div class="footer-about col-lg-3 col-md-12 col-sm-12 flex-grow-1">
              <div class="footer-widget ">
                <div class="footer-logo mb25">
                  <img :src="$filters.asset(`assets/images/logos/${Laravel.app.logo_w_image}`)" alt="logo">
                </div>

                <div v-if="footer_data.short_description.status === 1" class="footer-about-text">
                  <p>FX institut est un studio de création multidimensionnel spécialisé dans les domaines du design, du cinéma, des arts visuels et du développement qui dispose d'un programme de formation en ligne sur les effets visuels, la post-production et l'animation graphique dirigé par des professionnels...</p>
                </div>
              </div>
            </div>

            <footer-section v-for="(item, index) in footer_menus" :key="index" :title="item"></footer-section>

            <div class="footer-menu menu-sociality ms-0 col-lg-3 col-md-6 col-sm-12 flex-grow-1 flex-md-grow-0 flex-shrink-0 flex-md-shrink-1">
              <div class="footer-social ul-li ">
                <h2 class="widget-title">{{trans.get('labels.frontend.layouts.partials.social_network')}}</h2>
                <ul class="d-flex flex-nowrap justify-content-between">
                  <li v-for="(item, index) in footer_data.social_links.links" :key="index">
                    <router-link :to="`/${item.link}`"><i :class="item.icon"></i></router-link>
                  </li>

                </ul>
              </div>

              <div v-if="(footer_data.bottom_footer_links.status === 1 && footer_data.bottom_footer_links.links.length > 0)" class="menu-policy ul-li mt-4">
                <ul>
                  <li v-for="(item, index) in footer_data.bottom_footer_links.links" :key="index">
                    <router-link :to="`/${item.link}`">{{item.label}}</router-link>
                    <!-- <a href="{{$item->link}}">{{$item->label}}</a> -->
                  </li>
                  <li v-if="Laravel.app.show_offers">
                    <router-link :to="{ name: 'frontend.offers'}">{{trans.get('labels.frontend.layouts.partials.offers')}}</router-link>
                    <!-- <a href="{{route('frontend.offers')}}">{{ trans.get('labels.frontend.layouts.partials.offers') }}</a>  -->
                  </li>
                  <li>
                    <router-link :to="{ name:'frontend.certificates.getVerificationForm'}">{{trans.get('labels.frontend.layouts.partials.certificate_verification')}}</router-link>
                    <!-- <a href="{{route('frontend.certificates.getVerificationForm')}}">{{ trans.get('labels.frontend.layouts.partials.certificate_verification') }}</a> -->
                  </li>
                </ul>
              </div>

            </div>
          </div>

          <div v-if="footer_data.bottom_footer.status === 1" class="copy-right-menu">
            <div class="row">
              <div v-if="footer_data.copyright_text.status === 1" class="col-md-6">
                <div class="copy-right-text">
                  <p>Powered By <router-link :to="{ name:'home'}" class="me-4">FXinstitut</router-link> {{ footer_data.copyright_text.text }} </p>
                  <!-- <p>Powered By <a href="" target="_blank" class="me-4"> FXinstitut</a> Laravel.app.footer_data.copyright_text.text </p> -->
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </footer>
</template>

<script setup>
const { inject } = require("@vue/runtime-core");
const Laravel = inject("$laravel");
const footer_data = Laravel.app.footer_data;

const footer_menus = Object.keys(Laravel.app.footer_menus);

const $filters = inject("$filters");
</script>

