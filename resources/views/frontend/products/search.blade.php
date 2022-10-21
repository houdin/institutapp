@extends('frontend.layouts.app')

@section('content')
    <h1>Search for {{ $search }}</h1>
    <div class="row">
        @if(isset($products))
            @include('frontend.products.includes._products')
        @else
            <h1>No Products are available</h1>
        @endif
    </div><!-- /.row -->

@endsection
