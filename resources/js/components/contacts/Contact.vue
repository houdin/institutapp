<template>

  <span class="d-flex ">Support client</span>

  <div class="row bg-gray-8 py-5">
    <div class="col-md-6 ps-4">
      <div class="fxins-single-heading clearfix  has-line mb-3" style="">
        <span class="inner">
          <span class="line accent" style="width:40px;height:2px;">
          </span>
          <h2 class="widget-title">PAR MAIL</h2>
        </span>
      </div>
      <p>
        Si vous êtes un client et avez besoin d’aide pour un produit ou service, veuillez visiter notre <router-link
          to="https://fxinstitut.com/support" class="color-base-2">support client dédiée qui se trouve
          ici</router-link> afin que nous puissions vous aide.
        Sinon vous pouvez nous contacter par <a href="mailto:team@fxinstitut.com"
          class="color-base-2">team@fxinstitut.com</a>
      </p>
    </div>
    <div class="col-md-6">
      <div class="fxins-single-heading clearfix  has-line mb-3" style="">
        <span class="inner">
          <span class="line accent" style="width:40px;height:2px;">
          </span>
          <h2 class="widget-title">SUR LES RESEAUX
            SOCIAUX</h2>
        </span>
      </div>
      <div class="contact-menu-sociality ms-0 ">
        <div class="contact-social ul-li ">
          <ul>
            <li v-for="(item, index) in $laravel.app.footer_data.social_links.links" :key="index">
              <router-link :to="`/${item.link}`" style="font-size: 1.9rem;"><i :class="item.icon"></i></router-link>
            </li>

            <!-- @foreach($footer_data->social_links->links as $item)
            <li><a href="{{$item->link}}"><i class="{{$item->icon}} h3"></i></a></li>
            @endforeach -->

          </ul>
        </div>
      </div>

    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <img :src="$filters.ass et('assets/i mages/hero_bg.jpg')" alt="" class="pt-5 w-100">
    </div>
    <div class="col-md-6">
      <h2 class="mb-3 pt-4" style="font-size:55px;">Nous !</h2>
      <p class="sub-heading clearfix">
        FXinstitut est un studio de création multidimensionnel spécialisé dans les domaines du design, du cinéma, des
        arts visuels et du développement qui dispose d'un programme de formation en ligne sur les effets visuels, la
        post-production et l'animation graphique dirigé par des professionnels. Notre objectif est de produire des
        élements de qualité pour nos clients et de vous montrer ce qui est possible et comment les effets peuvent être
        créés afin que vous puissiez appliquer ces techniques à vos propres aventures créatives. Nous nous efforçons de
        développer des outils spéciaux qui améliorent la qualité et l'optimisaton de votre production.
      </p>
      <router-link :to="{ name: 'portfolios.index'}" class="btn bg-base-2 py-2 px-4"><span style="">NOTRE GALERIE
        </span></router-link>

    </div>
  </div>

</template>

<script setup lang="ts">
</script>

