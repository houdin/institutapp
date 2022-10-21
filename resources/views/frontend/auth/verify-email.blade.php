@extends('frontend.layouts.app')

@section('content')

    <div id="verification">
        <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <a href="{{ route('frontend.auth.account.confirm.resend', ['uuid' => Auth::user()->uuid]) }}" class="btn btn-secondary">{{ __('click here to request another') }}</a>
                        {{-- <form class="d-inline" method="GET" action="{{ route('frontend.auth.account.confirm.resend', ['uuid' => Auth::user()->uuid]) }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
