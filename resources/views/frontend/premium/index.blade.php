@extends('frontend.layouts.app')

@section('content')

{{-- <premium-index></premium-index> --}}

<router-view name="premiums"></router-view>
<router-view name="premium"></router-view>

<vue-progress-bar></vue-progress-bar>

 {{-- <section id="premium-page" class="premium-page-section _page_">

     <div class="container py-5">
         <h1 class="text-center pricing">Bootstrap pricing table</h1> <br>
         <div class="mb-5 text-center">
                    <h3 class=" mt-4">Pricing plans</h3>
                    <div class="fluid-paragraph mt-3">
                      <p class="lead lh-180">We'll make sure we build everything you need from now on</p>
                    </div>
                  </div>
         <div class="row text-center align-items-start">
             @foreach ($premiums as $item)
                 <div class="col-lg-4 mb-5 mb-lg-0">
                 <div class="bg-black-1 p-5 rounded-lg shadow border border-base-0">
                     <h1 class="h6 text-uppercase font-weight-bold mb-4">{{ $item->name }}</h1>
                     <h2 class="h1 font-weight-bold">${{ $item->price }}<span class="text-small font-weight-normal ml-2">/ month</span></h2>
                     <div class="custom-separator my-4 mx-auto bg-base-3"></div>
                     <ul class="list-unstyled my-5 text-small text-left">
                         @foreach ($item->premium_list as $line)
                             <li class="mb-3"> <i class="fa fa-check mr-2 text-primary"></i>{{ $line }}</li>
                         @endforeach

                     </ul> <a href="#" class="btn bg-base-3 btn-block color-black-0 p-2 shadow rounded-pill">Subscribe</a>
                 </div>
             </div>
             @endforeach

         </div>
     </div>
 </section> --}}

@endsection
