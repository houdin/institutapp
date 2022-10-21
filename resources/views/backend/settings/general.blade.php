@extends('backend.layouts.app')
@section('title', __('backend/labels.backend.general_settings.title') . ' | ' . app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/colors/switch.css') }}">
    <style>
        .color-list li {
            float: left;
            width: 8%;
        }

        @media screen and (max-width: 768px) {
            .color-list li {
                width: 20%;
                padding-bottom: 20px;
            }

            .color-list li:first-child {
                padding-bottom: 0px;
            }
        }

        .options {
            line-height: 35px;
        }

        .color-list li a {
            font-size: 20px;
        }

        .color-list li a.active {
            border: 4px solid grey;
        }

        .color-default {
            font-size: 18px !important;
            background: #101010;
            border-radius: 100%;
        }

        .form-control-label {
            line-height: 35px;
        }

        .switch.switch-3d {
            margin-bottom: 0px;
            vertical-align: middle;

        }

        .color-default i {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .preview {
            background-color: #dcd8d8;
            background-image: url(https://www.transparenttextures.com/patterns/carbon-fibre-v2.png);
        }

        #logos img {
            height: auto;
            width: 100%;
        }

    </style>
@endpush
@section('content')
    {{ html()->form('POST', route('admin.general-settings'))->id('general-settings-form')->class('form-horizontal')->acceptsFiles()->open() }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav main-nav-tabs nav-tabs">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-coreui-toggle="tab"
                                data-coreui-target="#general" type="button" role="tab" aria-controls="general"
                                aria-selected="true">
                                {{ __('backend/labels.backend.general_settings.title') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="layout-tab" data-coreui-toggle="tab"
                                data-coreui-target="#layout" type="button" role="tab" aria-controls="layout"
                                aria-selected="true">
                                {{ __('backend/labels.backend.general_settings.layout.title') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="email-tab" data-coreui-toggle="tab"
                                data-coreui-target="#email" type="button" role="tab" aria-controls="email"
                                aria-selected="true">
                                {{ __('backend/labels.backend.general_settings.email.title') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payment_settings-tab" data-coreui-toggle="tab"
                                data-coreui-target="#payment_settings" type="button" role="tab"
                                aria-controls="payment_settings" aria-selected="true">
                                {{ __('backend/labels.backend.general_settings.payment_settings.title') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="language_settings-tab" data-coreui-toggle="tab"
                                data-coreui-target="#language_settings" type="button" role="tab"
                                aria-controls="language_settings" aria-selected="true">
                                {{ __('backend/labels.backend.general_settings.language_settings.title') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="api_client_settings-tab" data-coreui-toggle="tab"
                                data-coreui-target="#api_client_settings" type="button" role="tab"
                                aria-controls="api_client_settings" aria-selected="true">
                                {{ __('backend/labels.backend.general_settings.api_clients.title') }}</button>
                        </li>
                    </ul>
                    <h4 class="card-title mb-0">
                        {{-- {{ __('backend/labels.backend.general_settings.management') }} --}}
                    </h4>
                </div>
                <!--col-->
            </div>
            <!--row-->

            <div class="tab-content">
                <!---General Tab--->
                <div id="general" class="tab-pane container active">
                    <div class="row mt-4 mb-4">
                        <div class="col ">

                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.google_analytics_id'))->class('col-md-2 form-control-label')->for('app_name') }}

                                <div class="col-md-10">
                                    {{ html()->text('google_analytics_id')->class('form-control')->placeholder('Ex. UA-34XXXXX23-3')->attribute('maxlength', 191)->value(config('google_analytics_id'))->autofocus() }}
                                    <span class="float-right">
                                        <a target="_blank" class="font-weight-bold font-italic"
                                            href="https://support.google.com/analytics/answer/1042508">{{ __('backend/labels.backend.general_settings.google_analytics_id_note') }}</a>
                                    </span>

                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('backend/validation.attributes.backend.settings.general_settings.captcha_status'))->class('col-md-2 form-control-label')->for('captcha_status') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
        html()->checkbox('access__captcha__registration', config('access.captcha.registration') ? true : false, 1)->id('captcha_status')->class('switch-input')->value(1) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                    </div>
                                    <span class="float-right">
                                        <a target="_blank" class="font-weight-bold font-italic"
                                            href="https://support.google.com/analytics/answer/1042508">{{ __('backend/labels.backend.general_settings.captcha_note') }}</a>
                                    </span>
                                    <small><i>{{ __('backend/labels.backend.general_settings.captcha') }}</i></small>
                                    <div id="captcha-credentials" class="@if (config('access.captcha.registration') == 0 || config('access.captcha.registration') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('backend/validation.attributes.backend.settings.general_settings.captcha_site_key'))->class('col-md-2 form-control-label')->for('captcha_site_key') }}
                                            <div class="col-md-10">
                                                {{ html()->text('no-captcha__sitekey')->class('form-control')->placeholder(__('backend/validation.attributes.backend.settings.general_settings.captcha_site_key'))->value(config('no-captcha.sitekey')) }}
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('backend/validation.attributes.backend.settings.general_settings.captcha_site_secret'))->class('col-md-2 form-control-label')->for('captcha_site_secret') }}
                                            <div class="col-md-10">
                                                {{ html()->text('no-captcha__secret')->class('form-control')->placeholder(__('backend/validation.attributes.backend.settings.general_settings.captcha_site_secret'))->value(config('no-captcha.secret')) }}
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--form-group-->
                                    </div>

                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('backend/validation.attributes.backend.settings.general_settings.retest_status'))->class('col-md-2 form-control-label')->for('retest') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
        html()->checkbox('retest', config('retest') ? true : false, 1)->id('retest')->class('switch-input')->value(1) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                    </div>
                                    <small><i>
                                            {{ __('backend/labels.backend.general_settings.retest_note') }}</i></small>
                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('backend/validation.attributes.backend.settings.general_settings.module_timer'))->class('col-md-2 form-control-label')->for('module_timer') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
        html()->checkbox('module_timer', config('module_timer') ? true : false, 1)->id('retest')->class('switch-input')->value(1) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                    </div>
                                    <small><i>
                                            {{ __('backend/labels.backend.general_settings.module_note') }}</i></small>
                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('backend/validation.attributes.backend.settings.general_settings.show_offers'))->class('col-md-2 form-control-label')->for('show_offers') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
        html()->checkbox('show_offers', config('show_offers') ? true : false, 1)->id('retest')->class('switch-input')->value(1) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                    </div>
                                    <small><i>
                                            {{ __('backend/labels.backend.general_settings.show_offers_note') }}</i></small>
                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('backend/validation.attributes.backend.settings.general_settings.one_signal_push_notification'))->class('col-md-2 form-control-label')->for('onesignal_status') }}
                                <div class="col-md-10">
                                    <div class="checkbox">
                                        {{ html()->label(
        html()->checkbox('onesignal_status', config('onesignal_status') ? true : false, 1)->id('onesignal_status')->class('switch-input')->value(1) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                    </div>
                                    <span class="float-right">
                                        <a target="_blank" class="font-weight-bold font-italic"
                                            href="https://documentation.onesignal.com/docs/web-push-quickstart">{{ __('backend/labels.backend.general_settings.how_to_onesignal') }}</a><br>
                                        <a target="_blank" class="font-weight-bold font-italic"
                                            href="https://documentation.onesignal.com/docs/web-push-custom-code-setup#section--span-class-step-step-3-span-upload-onesignal-sdk">{{ __('backend/labels.backend.general_settings.setup_onesignal') }}</a>
                                    </span>
                                    <small><i>{{ __('backend/labels.backend.general_settings.onesignal_note') }}</i></small>
                                    <div id="onesignal-configuration" class="@if (config('onesignal_status') == 0 || config('onesignal_status') == false) d-none @endif">
                                        <br>

                                        <div class="form-group row">

                                            <div class="col-md-12">
                                                {{ html()->textarea('onesignal_data')->class('form-control')->placeholder(__('backend/validation.attributes.backend.settings.general_settings.onesignal_code'))->value(config('onesignal_data')) }}
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--form-group-->
                                    </div>

                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.teacher_commission_rate'))->class('col-md-2 form-control-label')->for('commission_rate') }}

                                <div class="col-md-10">
                                    {{ html()->input('number', 'commission_rate')->class('form-control')->attributes(['pattern' => '[0-9]'])->placeholder(__('backend/labels.backend.general_settings.teacher_commission_rate'))->value(config('commission_rate')) }}
                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                        </div>
                        <div class="col-12 text-left">
                            <a href="{{ route('admin.troubleshoot') }}"
                                class="btn btn-lg btn-warning">{{ __('backend/labels.backend.general_settings.troubleshoot') }}</a>
                        </div>
                    </div>
                </div>

                <!---Layout Tab--->
                <div id="layout" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">

                            <div class="form-group row" id="sections">
                                <div class="col-md-10 offset-md-2">
                                    <div class="row">
                                        @foreach ($sections as $key => $item)
                                            <p style="line-height: 35px" class="col-md-4 col-12">
                                                {{ html()->label(
        html()->checkbox('')->id($key)->checked($item->status == 1 ? true : false)->class('switch-input')->value($item->status == 1 ? 1 : 0) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                                <span class="ml-2 title">{{ $item->title }}</span>
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!---SMTP Tab--->
                <div id="email" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.email.mail_from_name'))->class('col-md-2 form-control-label')->for('mail_from_name') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__from__name')->class('form-control')->placeholder(__('backend/labels.backend.general_settings.email.mail_from_name'))->attribute('maxlength', 191)->value(config('mail.from.name'))->autofocus() }}
                                    <span
                                        class="help-text font-italic">{{ __('backend/labels.backend.general_settings.email.mail_from_name_note') }}</span>

                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.email.mail_from_address'))->class('col-md-2 form-control-label')->for('mail_from_address') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__from__address')->class('form-control')->placeholder(__('backend/labels.backend.general_settings.email.mail_from_address'))->attribute('maxlength', 191)->value(config('mail.from.address'))->autofocus() }}
                                    <span
                                        class="help-text font-italic">{{ __('backend/labels.backend.general_settings.email.mail_from_address_note') }}</span>

                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.email.mail_driver'))->class('col-md-2 form-control-label')->for('mail_driver') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__driver')->class('form-control')->placeholder(__('backend/labels.backend.general_settings.email.mail_driver'))->attribute('maxlength', 191)->value(config('mail.driver')) }}
                                    <span class="help-text font-italic">{!! __('backend/labels.backend.general_settings.email.mail_driver_note') !!}</span>

                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.email.mail_host'))->class('col-md-2 form-control-label')->for('mail_host') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__host')->class('form-control')->placeholder(__('backend/labels.backend.general_settings.email.mail_driver'))->attribute('maxlength', 191)->placeholder('Ex. smtp.gmail.com')->value(config('mail.host')) }}
                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.email.mail_port'))->class('col-md-2 form-control-label')->for('mail_port') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__port')->class('form-control')->placeholder(__('backend/labels.backend.general_settings.email.mail_port'))->attribute('maxlength', 191)->placeholder('Ex. 465')->value(config('mail.port')) }}
                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->

                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.email.mail_username'))->class('col-md-2 form-control-label')->for('mail_username') }}

                                <div class="col-md-10">
                                    {{ html()->text('mail__username')->class('form-control')->placeholder(__('backend/labels.backend.general_settings.email.mail_username'))->attribute('maxlength', 191)->placeholder('Ex. myemail@email.com')->value(config('mail.username')) }}
                                    <span class="help-text font-italic">{!! __('backend/labels.backend.general_settings.email.mail_username_note') !!}</span>

                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.email.mail_password'))->class('col-md-2 form-control-label')->for('mail_password') }}

                                <div class="col-md-10">
                                    {{ html()->password('mail__password')->class('form-control')->placeholder(__('backend/labels.backend.general_settings.email.mail_password'))->attribute('maxlength', 191)->placeholder(__('backend/labels.backend.general_settings.email.mail_password'))->value(config('mail.password')) }}
                                    <span class="help-text font-italic">{!! __('backend/labels.backend.general_settings.email.mail_password_note') !!}</span>

                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.email.mail_encryption'))->class('col-md-2 form-control-label')->for('mail_encryption') }}

                                <div class="col-md-10">
                                    {{ html()->select('mail__encryption', ['tls' => 'tls', 'ssl' => 'ssl', 'none' => 'none'], config('mail.encryption') == null ? 'none' : config('mail.encryption'))->class('form-control') }}

                                    <span class="help-text font-italic">{!! __('backend/labels.backend.general_settings.email.mail_encryption_note') !!}</span>

                                </div>
                                <!--col-->

                            </div>
                            <!--form-group-->
                            <hr>



                        </div>
                    </div>
                </div>

                <!---Payment Configuration Tab--->
                <div id="payment_settings" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.select_currency'))->class('col-md-3 form-control-label') }}
                                <div class="col-md-9">
                                    <select class="form-control" id="app__currency" name="app__currency">
                                        @foreach (config('currencies') as $currency)
                                            <option @if (config('app.currency') == $currency['short_code']) selected
                                                @endif value="{{ $currency['short_code'] }}">
                                                {{ $currency['symbol'] . ' - ' . $currency['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.stripe'))->class('col-md-3 form-control-label')->for('services.stripe.active') }}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
        html()->checkbox('services__stripe__active', config('services.stripe.active') ? true : false, 1)->class('switch-input')->value(1) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                        <a class="float-right font-weight-bold font-italic"
                                            href="https://stripe.com/docs/keys"
                                            target="_blank">{{ __('backend/labels.backend.general_settings.payment_settings.how_to_stripe') }}</a>
                                    </div>
                                    <small>
                                        <i>
                                            {{ __('backend/labels.backend.general_settings.payment_settings.stripe_note') }}</i>
                                    </small>
                                    <div class="switch-content @if (config('services.stripe.active') == 0 || config('services.stripe.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.key'))->class('col-md-2 form-control-label')->for('services.stripe.key') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__stripe__key')->class('form-control')->value(config('services.stripe.key')) }}
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.secret'))->class('col-md-2 form-control-label')->for('services.stripe.secret') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('services__stripe__secret')->class('form-control')->value(config('services.stripe.secret')) }}
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--form-group-->
                                    </div>
                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.paypal'))->class('col-md-3 form-control-label') }}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
        html()->checkbox('paypal__active', config('paypal.active') ? true : false, 1)->class('switch-input')->value(1) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                        <a target="_blank" href="https://developer.paypal.com/developer/applications/"
                                            class="float-right font-italic font-weight-bold">{{ __('backend/labels.backend.general_settings.payment_settings.how_to_paypal') }}</a>
                                    </div>
                                    <small>
                                        <i>
                                            {{ __('backend/labels.backend.general_settings.payment_settings.paypal_note') }}</i>
                                    </small>
                                    <div class="switch-content @if (config('paypal.active') == 0 || config('paypal.active') == false) d-none @endif">
                                        <br>
                                        <div class="form-group row">
                                            {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.mode'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" id="paypal_settings_mode"
                                                    name="paypal__settings__mode">
                                                    <option selected value="sandbox">
                                                        {{ __('backend/labels.backend.general_settings.payment_settings.sandbox') }}
                                                    </option>
                                                    <option value="live">
                                                        {{ __('backend/labels.backend.general_settings.payment_settings.live') }}
                                                    </option>
                                                </select>
                                                <span class="help-text font-italic">{!! __('backend/labels.backend.general_settings.payment_settings.mode_note') !!}</span>
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.client_id'))->class('col-md-2 form-control-label') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('paypal__client_id')->class('form-control')->value(config('paypal.client_id')) }}
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--form-group-->
                                        <div class="form-group row">
                                            {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.client_secret'))->class('col-md-2 form-control-label')->for('paypal.paypal.secret') }}
                                            <div class="col-md-8 col-xs-12">
                                                {{ html()->text('paypal__secret')->class('form-control')->value(config('paypal.secret')) }}
                                            </div>
                                            <!--col-->
                                        </div>
                                        <!--form-group-->
                                    </div>
                                </div>
                                <!--col-->
                            </div>
                            <!--form-group-->
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.payment_settings.offline_mode'))->class('col-md-3 form-control-label') }}
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        {{ html()->label(
        html()->checkbox('payment_offline_active', config('payment_offline_active') ? true : false, 1)->class('switch-input')->value(1) . '<span class="switch-label"></span><span class="switch-handle"></span>',
    )->class('switch switch-sm switch-3d switch-primary') }}
                                    </div>
                                    <small>
                                        <i>
                                            {{ __('backend/labels.backend.general_settings.payment_settings.offline_mode_note') }}</i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Language Tab--->
                <div id="language_settings" class="tab-pane container fade">
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label(__('backend/labels.backend.general_settings.language_settings.default_language'))->class('col-md-2 form-control-label')->for('default_language') }}
                                <div class="col-md-10">
                                    <select class="form-control" id="app_locale" name="app__locale">
                                        @foreach ($app_locales as $lang)
                                            <option data-display-type="{{ $lang->display_type }}" @if ($lang->is_default == 1) selected
                                        @endif
                                        value="{{ $lang->short_name }}">{{ trans('backend/menus.language-picker.langs.' . $lang) ? trans('backend/menus.language-picker.langs.' . $lang->short_name) : $lang }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <!---API Client Settings--->
                <div id="api_client_settings" class="tab-pane container fade">
                    <div class="row mb-4">
                        <div class="col-lg-8 col-12">
                            <h4>{{ __('backend/labels.backend.general_settings.api_clients.title') }}</h4>
                        </div>
                        <div class="col-lg-4 col-12">
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" id="api_client_name" class="form-control"
                                        placeholder="{{ __('backend/labels.backend.general_settings.api_clients.api_client_name') }}">
                                    <div class="input-group-append" id="button-addon2">
                                        <button class="btn btn-primary generate-client"
                                            type="button">{{ __('backend/labels.backend.general_settings.api_clients.generate') }}</button>
                                    </div>
                                </div>
                                <span class="text-danger" id="api_client_name_error"></span>
                            </fieldset>
                        </div>
                        <div class="col-12 mt-2">
                            <p>{!! __('backend/labels.backend.general_settings.api_clients.note') !!}</p>

                            <a target="_blank" href="https://documenter.getpostman.com/view/5183624/SW18uZwk?version=latest"
                                class="btn btn-dark  font-weight-bold text-white">{{ __('backend/labels.backend.general_settings.api_clients.developer_manual') }}
                                <i class="fa fa-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                    <div class="row mt-4 mb-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered dataTable" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('backend/labels.backend.general_settings.api_clients.fields.name') }}
                                            </th>
                                            <th>{{ __('backend/labels.backend.general_settings.api_clients.fields.id') }}
                                            </th>
                                            <th>{{ __('backend/labels.backend.general_settings.api_clients.fields.secret') }}
                                            </th>
                                            <th>{{ __('backend/labels.backend.general_settings.api_clients.fields.status') }}
                                            </th>
                                            <th>{{ __('backend/labels.backend.general_settings.api_clients.fields.action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($api_clients as $key => $client)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->id }}</td>
                                                <td>{{ $client->secret }}</td>
                                                <td>{{ $client->revoked ? __('backend/labels.backend.general_settings.api_clients.revoked') : __('backend/labels.backend.general_settings.api_clients.live') }}
                                                </td>
                                                <td>
                                                    @if (!$client->revoked)
                                                        <a data-id="{{ $client->id }}"
                                                            class="btn btn-sm revoke-api-client btn-danger"
                                                            href="#">{{ __('backend/labels.backend.general_settings.api_clients.revoke') }}</a>
                                                    @else
                                                        <a data-id="{{ $client->id }}"
                                                            class="btn btn-sm btn-success revoke-api-client"
                                                            href="#">{{ __('backend/labels.backend.general_settings.api_clients.enable') }}</a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="row">
                        <div class="col">
                            {{ form_cancel(route('admin.general-settings'), __('backend/buttons.general.cancel')) }}
                        </div>
                        <!--col-->
                        <div class="col text-right">
                            {{ form_submit(__('backend/buttons.general.crud.update'))->id('submit') }}
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                </div>
                <!--card-footer-->
            </div>
            <!--card-->
        </div>
    </div>
    {{ html()->form()->close() }}
@endsection


@push('after-scripts')
    <script src="{{ asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            @if (request()->has('tab'))
                var tab = "{{ request('tab') }}";
                $('.nav-tabs a[href="#' + tab + '"]').tab('show');
            @endif

            //========= Initialisation for Iconpicker ===========//
            $('#icon').iconpicker({
                cols: 10,
                icon: 'fab fa-facebook-f',
                iconset: 'fontawesome5',
                labelHeader: '{0} of {1} pages',
                labelFooter: '{0} - {1} of {2} icons',
                placement: 'bottom', // Only in button tag
                rows: 5,
                search: true,
                searchText: 'Search',
                selectedClass: 'btn-success',
                unselectedClass: ''
            });



            //=========== Preset Counter data =============//
            @if (config('counter') != '')
                @if ((int) config('counter') == 1)
                    $('.counter-container').removeClass('d-none')
                    $('#total_students').val("{{ config('total_students') }}");
                    $('#total_teachers').val("{{ config('total_teachers') }}");
                    $('#total_formations').val("{{ config('total_formations') }}");
                @else
                    $('#counter-container').empty();
                @endif

                @if (config('counter') != '')
                    $('.counter-container').removeClass('d-none');
                @endif

                $('#counter').find('option').removeAttr('selected')
                $('#counter').find('option[value="{{ config('counter') }}"]').attr('selected', 'selected');
            @endif


            //======== Preset PaymentMode for Paypal =======>
            @if (config('paypal.settings.mode') != '')
                $('#paypal_settings_mode').find('option').removeAttr('selected')
                $('#paypal_settings_mode').find('option[value="{{ config('paypal.settings.mode') }}"]').attr('selected',
                'selected');
            @endif


            // //============= Font Color selection =================//
            // $(document).on('click', '.color-list li', function () {
            //     $(this).siblings('li').find('a').removeClass('active')
            //     $(this).find('a').addClass('active');
            //     $('#font_color').val($(this).find('a').data('color'));
            // });


            //============== Captcha status =============//
            $(document).on('click', '#captcha_status', function(e) {
                //              e.preventDefault();
                if ($('#captcha-credentials').hasClass('d-none')) {
                    $('#captcha_status').attr('checked', 'checked');
                    $('#captcha-credentials').find('input').attr('required', true);
                    $('#captcha-credentials').removeClass('d-none');
                } else {
                    $('#captcha-credentials').addClass('d-none');
                    $('#captcha-credentials').find('input').attr('required', false);
                }
            });

            //============== One Signal status =============//
            $(document).on('click', '#onesignal_status', function(e) {
                //              e.preventDefault();
                if ($('#onesignal-configuration').hasClass('d-none')) {
                    console.log('here')
                    $('#onesignal_status').attr('checked', 'checked');
                    $('#onesignal-configuration').removeClass('d-none').find('textarea').attr('required',
                        true);
                } else {
                    $('#onesignal-configuration').addClass('d-none').find('textarea').attr('required',
                        false);
                }
            });


            //===== Counter value on change ==========//
            $(document).on('change', '#counter', function() {
                if ($(this).val() == 1) {
                    $('.counter-container').empty().removeClass('d-none');
                    var html =
                        "<input class='form-control my-2' type='text' id='total_students' name='total_students' placeholder='" +
                        "{{ __('backend/labels.backend.general_settings.total_students') }}" +
                        "'><input type='text' id='total_formations' class='form-control mb-2' name='total_formations' placeholder='" +
                        "{{ __('backend/labels.backend.general_settings.total_formations') }}" +
                        "'><input type='text' class='form-control mb-2' id='total_teachers' name='total_teachers' placeholder='" +
                        "{{ __('backend/labels.backend.general_settings.total_teachers') }}" + "'>";

                    $('.counter-container').append(html);
                } else {
                    $('.counter-container').addClass('d-none');
                }
            });


            //========== Preview image function on upload =============//
            var previewImage = function(input, block) {
                var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
                var extension = input.files[0].name.split('.').pop().toLowerCase();
                var isSuccess = fileTypes.indexOf(extension) > -1;

                if (isSuccess) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $(block).find('img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert('Please input valid file!');
                }

            };
            $(document).on('change', 'input[type="file"]', function() {
                previewImage(this, $(this).data('preview'));
            });


            //========== Registration fields status =========//
            @if (config('registration_fields') != null)
                var fields = "{{ config('registration_fields') }}";

                fields = JSON.parse(fields.replace(/&quot;/g, '"'));

                $(fields).each(function (key,element) {
                appendElement(element.type,element.name);
                $('.input-list').find('[data-name="'+element.name+'"]').attr('checked',true)

                });

            @endif


            //======= Saving settings for All tabs =================//
            $(document).on('submit', '#general-settings-form', function(e) {
                //                e.preventDefault();

                //======Saving Layout sections details=====//
                var sections = $('#sections').find('input[type="checkbox"]');
                var title, name, status;
                var sections_data = {};
                $(sections).each(function() {
                    if ($(this).is(':checked')) {
                        status = 1
                    } else {
                        status = 0
                    }
                    name = $(this).attr('id');
                    title = $(this).parent('label').siblings('.title').html();
                    sections_data[name] = {
                        title: title,
                        status: status
                    }
                });
                $('#section_data').val(JSON.stringify(sections_data));

                //=========Saving Registration fields ===============//
                var inputName, inputType;
                var fieldsData = [];
                var registrationFields = $('.input-list').find('.option:checked');
                $(registrationFields).each(function(key, value) {
                    inputName = $(value).attr('data-name');
                    inputType = $(value).attr('data-type');
                    fieldsData.push({
                        name: inputName,
                        type: inputType
                    });
                });
                $('#registration_fields').val(JSON.stringify(fieldsData));

            });


            @if (request()->has('tab'))
                var tab = "{{ request('tab') }}";
                $('.nav-tabs a[href="#' + tab + '"]').tab('show');
            @endif

        });

        $(document).on('click', '.switch-input', function(e) {
            //              e.preventDefault();
            var content = $(this).parents('.checkbox').siblings('.switch-content');
            if (content.hasClass('d-none')) {
                $(this).attr('checked', 'checked');
                content.find('input').attr('required', true);
                content.removeClass('d-none');
            } else {
                content.addClass('d-none');
                content.find('input').attr('required', false);
            }
        })


        //On Default language change update Display type RTL/LTR
        $(document).on('change', '#app_locale', function() {
            var display_type = $(this).find(":selected").data('display-type');
            $('#app_display_type').val(display_type)
        });


        //On click add input list
        $(document).on('click', '.input-list input[type="checkbox"]', function() {

            var html;
            var type = $(this).data('type');
            var name = $(this).data('name');
            var textInputs = ['text', 'date', 'number'];
            if ($(this).is(':checked')) {
                appendElement(type, name)
            } else {
                if ((textInputs.includes(type)) || (type == 'textarea')) {
                    $('.input-boxes').find('[data-name="' + name + '"]').parents('.form-group').remove();
                } else if (type == 'radio') {
                    $('.input-boxes').find('.radiogroup').remove();
                }
            }
        });


        //Revoke App Client Secret
        $(document).on('click', '.revoke-api-client', function() {
            var api_id = $(this).data('id');
            $.ajax({
                url: '{{ route('admin.api-client.status') }}',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'api_id': api_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.href =
                            '{{ route('admin.general-settings', ['tab' => 'api_client_settings']) }}'

                    } else {
                        alert(
                            "{{ __('backend/labels.backend.general_settings.api_clients.something_went_wrong') }}"
                        );
                    }

                }
            })
        });

        $(document).on('click', '.generate-client', function() {
            var api_client_name = $('#api_client_name').val();

            if ($.trim(api_client_name).length > 0) { // zero-length string AFTER a trim
                $.ajax({
                    url: '{{ route('admin.api-client.generate') }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        'api_client_name': api_client_name,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href =
                                '{{ route('admin.general-settings', ['tab' => 'api_client_settings']) }}'

                        } else {
                            alert(
                                "{{ __('backend/labels.backend.general_settings.api_clients.something_went_wrong') }}"
                            );
                        }

                    }
                })
            } else {
                $('#api_client_name_error').text(
                    "{{ __('backend/labels.backend.general_settings.api_clients.please_input_api_client_name') }}"
                );
            }

        });

        function appendElement(type, name) {
            var values =
                "{{ json_encode(Lang::get('backend/labels.backend.general_settings.user_registration_settings.fields')) }}";
            values = JSON.parse(values.replace(/&quot;/g, '"'));
            var textInputs = ['text', 'date', 'number'];
            var html;
            if (textInputs.includes(type)) {
                html = "<div class='form-group'>" +
                    "<input type='" + type + "' readonly data-name='" + name + "' placeholder='" + values[name] +
                    "' class='form-control'>" +
                    "</div>";
            } else if (type == 'radio') {
                html = "<div class='form-group radiogroup'>" +
                    "<label class='radio-inline mr-3'><input type='radio' data-name='optradio'> {{ __('backend/labels.backend.general_settings.user_registration_settings.fields.male') }} </label>" +
                    "<label class='radio-inline mr-3'><input type='radio' data-name='optradio'> {{ __('backend/labels.backend.general_settings.user_registration_settings.fields.female') }}</label>" +
                    "<label class='radio-inline mr-3'><input type='radio' data-name='optradio'> {{ __('backend/labels.backend.general_settings.user_registration_settings.fields.other') }}</label>" +
                    "</div>";
            } else if (type == 'textarea') {
                html = "<div class='form-group'>" +
                    "<textarea  readonly data-name='" + name + "' placeholder='" + values[name] +
                    "' class='form-control'></textarea>" +
                    "</div>";
            }
            $('.input-boxes').append(html)
        }
    </script>
@endpush
