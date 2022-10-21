@extends('frontend.layouts.app')

@section('content')
    <user-order :order_id="'{{ $order_id }}'"
                :need_total="true">

    </user-order>
@endsection
