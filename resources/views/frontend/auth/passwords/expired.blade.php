@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.expired_password_box_title'))

@section('content')

    <section id="about-page" class="about-page-section pb-0">

    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-6 align-self-center">
            <div class="card border-0">
                <div class="card-body">
                    {{ html()->form('PATCH', route('frontend.auth.password.expired.update'))->class('form-horizontal')->open() }}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.old_password'))->for('old_password') }}

                                    {{ html()->password('old_password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.old_password'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                   <button class="btn btn-info" type="submit">{{__('labels.frontend.passwords.update_password_button')}}</button>
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                    {{ html()->form()->close() }}
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-6 -->
    </div><!-- row -->
    </section>
@endsection
