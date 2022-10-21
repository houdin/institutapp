@extends('frontend.layouts.app')

@section('content')
    @include('frontend.products.partials._messages')
    <user-account :user="'{{ $user }}'">

    </user-account>
@endsection
