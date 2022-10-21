@extends('frontend.layouts.app')

@section('content')

 <section id="premium-page" class="premium-page-section _page_">
    <ul class="nav justify-content-center">
        <li class="nav-item">

            <router-link to="/devis/type" class="nav-link active">Type</router-link>
        </li>
        <li class="nav-item">
            <router-link to="/devis/personal-information" class="nav-link active">Information</router-link>
        </li>
        <li class="nav-item">
            <router-link to="{{ route('blogs.index') }}" class="nav-link active">Blog</router-link>
        </li>

    </ul>

    <router-view></router-view>

    <h1>Bonjour</h1>
     {{-- <div class="container py-5">
         <h1 class="text-center pricing">Bootstrap pricing table</h1> <br>
         <div class="mb-5 text-center">
                    <h3 class=" mt-4">Pricing plans</h3>
                    <div class="fluid-paragraph mt-3">
                      <p class="lead lh-180">We'll make sure we build everything you need from now on</p>
                    </div>
        </div>


        @include('frontend.products.partials._messages')
        <quotation-page
                    :stage="'{{ $stage }}'"
                    :user_order="'{{ $order }}'">
        </quotation-page>


     </div> --}}
 </section>

@endsection
