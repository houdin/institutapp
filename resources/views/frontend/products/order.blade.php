@extends('frontend.layouts.app')

@section('content')
    @include('frontend.products.partials._messages')
    <order-page
                :stage="'{{ $stage }}'"
                :user_order="'{{ $order }}'">
    </order-page>
@endsection

@section('js')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection
