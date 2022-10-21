@extends('frontend.layouts.app')

@section('title', 'Contact | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@push('after-styles')
<style>
    .my-alert {
        position: absolute;
        z-index: 10;
        left: 0;
        right: 0;
        top: 25%;
        width: 50%;
        margin: auto;
        display: inline-block;
    }
</style>
@endpush

@section('content')
@php
$footer_data = json_decode(config('footer_data'));
@endphp
@if(session()->has('alert'))
<div class="alert alert-light alert-dismissible fade my-alert show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>{{session('alert')}}</strong>
</div>
@endif



<!-- Start of contact section
        ============================================= -->
<section id="">
    <div class="container">
        <div class="row">
            <div class="ml-3 my-4">
                <span>Support client</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="fxins-single-heading clearfix  has-line mb-3" style="">
                    <span class="inner">
                        <span class="line accent" style="width:40px;height:2px;">
                        </span>
                        <h2 class="widget-title">PAR MAIL</h2>
                    </span>
                </div>
                <p>
                    Si vous êtes un client et avez besoin d’aide pour un produit ou service, veuillez visiter notre <a
                        href="https://fxinstitut.com/support" class="color-base-3">support client dédiée qui se trouve
                        ici</a> afin que nous puissions vous aide.
                    Sinon vous pouvez nous contacter par <a href="mailto:team@fxinstitut.com"
                        class="color-base-3">team@fxinstitut.com</a>
                </p>
            </div>
            <div class="col-md-6">
                <div class="fxins-single-heading clearfix  has-line mb-3" style="">
                    <span class="inner">
                        <span class="line accent" style="width:40px;height:2px;">
                        </span>
                        <h2 class="widget-title" >SUR LES RESEAUX
                            SOCIAUX</h2>
                    </span>
                </div>
                <div class="contact-menu-sociality ml-0 ">
                    <div class="contact-social ul-li ">
                        <ul>
                            @foreach($footer_data->social_links->links as $item)
                                <li><a href="{{$item->link}}"><i class="{{$item->icon}} h3" ></i></a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/hero_bg.jpg') }}" alt="" class="pt-5" width="110%">
            </div>
            <div class="col-md-6">
                <h2 class="mb-3 pt-5" style="font-size:55px;">Nous !</h2>
                <p class="sub-heading clearfix" >
                    FXinstitut est un studio de création multidimensionnel spécialisé dans les domaines du design, du cinéma, des arts visuels et du développement qui dispose d'un programme de formation en ligne sur les effets visuels, la post-production et l'animation graphique dirigé par des professionnels. Notre objectif est de produire des élements de qualité pour nos clients et de vous montrer ce qui est possible et comment les effets peuvent être créés afin que vous puissiez appliquer ces techniques à vos propres aventures créatives. Nous nous efforçons de développer des outils spéciaux qui améliorent la qualité et l'optimisaton de votre production.
                </p>

                <a href="{{ route('portfolios.all') }}"  class="btn bg-base-3 py-2 px-4">
                    <span style="">NOTRE GALERIE </span></a>

            </div>
        </div>
    </div>
</section>
<!-- End of contact section
        ============================================= -->



@endsection
