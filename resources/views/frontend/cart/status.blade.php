@extends('frontend.layouts.app')
@section('title', trans('labels.frontend.cart.payment_status').' | '.app_name())

@push('after-styles')
    <style>
        input[type="radio"] {
            display: inline-block !important;
        }
    </style>
@endpush

@section('content')


    <section id="checkout" class="checkout-section">
        <div class="container">
            <div class="section-title mb45 headline text-center">
                @if(Session::has('success'))
                    <h2>  {{session('success')}}</h2>
                    <h3>@lang('labels.frontend.cart.success_message')</h3>
                    <h4><a href="{{route('admin.dashboard')}}">@lang('labels.frontend.cart.see_more_formations')</a></h4>
                @endif
                @if(Session::has('failure'))

                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h2>  {{session('failure')}}</h2>
                    <h4><a href="{{route('cart.index')}}">@lang('labels.frontend.cart.go_back_to_cart')</a></h4>
                @endif
            </div>
        </div>
    </section>
@endsection
