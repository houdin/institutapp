@if(!auth()->check())

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">


                <!-- Modal Header -->
                <div class="modal-header background-style">

                    <div class="modal-header-bg"></div>
                    <div class="popup-logo">
                        <img src="{{asset("assets/images/logos/".config('app.logo_popup'))}}" alt="">
                    </div>
                    <div class="popup-text text-center">
                        <div>
                            <h2 id="modal_title_login">Se Connecter</h2>
                            <h2 id="modal_title_register" style="display: none">S'inscrire</h2>
                        </div>

                        <p id="modal_head_register" class="" >Vous n'avez pas encore de compte? <a href="#" class="go-register special">S'inscrire</a></p>
                        <p id="modal_head_login" class="" style="display: none">Vous avez déjà un compte? <a href="#" class="go-login special">Se connecter</a></p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="tab-content" id="login-registration">
                        <div class="tab-pane container active" id="login2">

                            <span class="error-response special-danger"></span>
                            <span class="success-response text-success">{{(session()->get('flash_success'))}}</span>
                            <form class="contact_form" id="loginForm" action="{{route('frontend.auth.login')}}"
                                  method="POST" enctype="multipart/form-data">
                                  {{-- @csrf --}}
                                  {{-- {!! csrf_token() !!} --}}
                                <div class="contact-info mb-2">
                                    {{ html()->email('email')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        }}

                                    <span id="login-email-error" class="special-danger"></span>

                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password')
                                                     ->class('form-control mb-0')
                                                     ->placeholder(__('validation.attributes.frontend.password'))
                                                    }}

                                    <span id="login-password-error" class="special-danger"></span>



                                </div>

                                @if(config('access.captcha.registration'))
                                    <div class="contact-info mb-2 text-center">
                                        {!! no_captcha()->display() !!}
                                        {{ html()->hidden('captcha_status', 'true') }}
                                        <span id="login-captcha-error" class="special-danger"></span>

                                    </div><!--col-->
                                @endif

                                <div class="nws-button text-center white text-capitalize">
                                    <button type="submit"
                                            value="Submit">@lang('labels.frontend.modal.login_now')</button>
                                </div>
                                <a class="special p-0 d-block text-center my-3"
                                       href="{{ route('frontend.auth.password.reset') }}">@lang('labels.frontend.passwords.forgot_password')</a>

                            </form>

                            <div id="socialLinks2" class="text-center">
                            </div>

                        </div>
                        <div class="tab-pane container fade" id="register2">

                            <form id="registerForm" class="contact_form"
                                  {{-- action="{{ route('frontend.auth.register.post')}}" --}}
                                  action="#"
                                  method="post">
                                  @csrf
                                {{-- {!! csrf_field() !!} --}}
                                <div class="contact-info mb-2">


                                    {{ html()->text('first_name')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.first_name'))
                                        ->attribute('maxlength', 191) }}
                                    <span id="first-name-error" class="special-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->text('last_name')
                                      ->class('form-control mb-0')
                                      ->placeholder(__('validation.attributes.frontend.last_name'))
                                      ->attribute('maxlength', 191) }}
                                    <span id="last-name-error" class="special-danger"></span>

                                </div>

                                <div class="contact-info mb-2">
                                    {{ html()->email('email')
                                       ->class('form-control mb-0')
                                       ->placeholder(__('validation.attributes.frontend.email'))
                                       ->attribute('maxlength', 191)
                                       }}
                                    <span id="email-error" class="special-danger"></span>

                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                         }}
                                    <span id="password-error" class="special-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password_confirmation')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                         }}
                                </div>
                                @if(config('registration_fields') != NULL)
                                    @php
                                        $fields = json_decode(config('registration_fields'));
                                        $inputs = ['text','number','date'];
                                    @endphp
                                    @foreach($fields as $item)
                                        @if(in_array($item->type,$inputs))
                                            <div class="contact-info mb-2">
                                                <input type="{{$item->type}}" class="form-control mb-0" value="{{old($item->name)}}" name="{{$item->name}}"
                                                       placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)}}">
                                            </div>
                                        @elseif($item->type == 'gender')
                                            <div class="contact-info mb-2">
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="male"> {{__('validation.attributes.frontend.male')}}
                                                </label>
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="female"> {{__('validation.attributes.frontend.female')}}
                                                </label>
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="other"> {{__('validation.attributes.frontend.other')}}
                                                </label>
                                            </div>
                                        @elseif($item->type == 'textarea')
                                            <div class="contact-info mb-2">

                                            <textarea name="{{$item->name}}" placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)}}" class="form-control mb-0">{{old($item->name)}}</textarea>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                                @if(config('access.captcha.registration'))
                                    <div class="contact-info mt-3 text-center">
                                        {!! no_captcha()->display() !!}
                                        {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                                        <span id="captcha-error" class="special-danger"></span>

                                    </div><!--col-->
                                @endif


                                <div class="nws-button text-center white text-capitalize">
                                    <button id="registerButton" type="submit"
                                            value="Submit">@lang('labels.frontend.modal.register_now')</button>
                                </div>


                                <a href="{{ route('frontend.auth.teacher.register') }}"
                                   class="fgo-register float-left special mt-2 mb-3 w-100">
                                    @lang('labels.teacher.teacher_register')
                                </a>
                            </form>
                            <div class="lrm-integrations lrm-integrations--register">
                                <p style="font-size: 13px; line-height: 1.6">Ce formulaire utilise <a class="special" href="https://www.google.com/recaptcha/intro/android.html">reCAPTCHA</a> afin de lutter contre le SPAM. L'utilisation de cette fonctionnalité est soumise aux <a class="special" href="https://www.google.com/intl/fr/policies/privacy/">Règles de confidentialité</a> et aux <a class="special" href="https://www.google.com/intl/fr/policies/terms/">Conditions d'utilisation</a> de Google.</p>
                            </div>
                        </div>
                        <div class="tab-pane container fade" id="verification">
                             <span class="error-response text-danger"></span>
                            <span class="success-response text-success">{{(session()->get('flash_success'))}}</span>
                            <p id="verify_modal_text" class="">

                            </p>
                            <div class="contact-info mb-2 mx-auto w-50 py-4">
                                    <div id="verify_btn" class="nws-button text-center white">

                                    </div>
                                </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endif

@push('after-scripts')
    @if (session('openModel'))
        <script>
            $('#myModal').modal('show');
        </script>
    @endif


    @if(config('access.captcha.registration'))
        {!! no_captcha()->script() !!}
    @endif

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                $(document).on('click', '.go-login', function () {
                    $('#register').removeClass('active').addClass('fade')
                    $('#login').addClass('active').removeClass('fade')
                    $('#modal_head_login').hide()
                    $('#modal_head_register').show()
                    $('#modal_title_register').hide()
                    $('#modal_title_login').show()

                });
                $(document).on('click', '.go-register', function () {
                    $('#login').removeClass('active').addClass('fade')
                    $('#register').addClass('active').removeClass('fade')
                    $('#modal_head_register').hide()
                    $('#modal_head_login').show()
                    $('#modal_title_login').hide()
                    $('#modal_title_register').show()
                });

                $(document).on('click', '#openLoginModal', function (e) {
                    $('#modal_title').empty().html("@lang('labels.frontend.modal.my_account')");
                    $('#modal_head_link').show();
                    $('#verification').removeClass('active').addClass('fade')
                    $('#login').addClass('active').removeClass('fade')
                    $.ajax({
                        type: "GET",
                        url: "{{route('frontend.auth.login')}}",
                        success: function (response) {
                            $('#socialLinks').html(response.socialLinks)
                            $('#myModal').modal('show');
                        },
                    });
                });

                $('#loginForm').on('submit', function (e) {
                    e.preventDefault();

                    var $this = $(this);
                    $('.success-response').empty();
                    $('.error-response').empty();

                    $.ajax({
                        type: $this.attr('method'),
                        url: $this.attr('action'),
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function (response) {
                            $('#login-email-error').empty();
                            $('#login-password-error').empty();
                            $('#login-captcha-error').empty();

                            if (response.errors) {
                                if (response.errors.email) {
                                    $('#login-email-error').html(response.errors.email[0]);
                                }
                                if (response.errors.password) {
                                    $('#login-password-error').html(response.errors.password[0]);
                                }

                                var captcha = "g-recaptcha-response";
                                if (response.errors[captcha]) {
                                    $('#login-captcha-error').html(response.errors[captcha][0]);
                                }
                            }
                            if (response.success) {
                                $('#loginForm')[0].reset();
                                if (response.redirect == 'back') {
                                    location.reload();
                                } else {
                                    window.location.href = "{{route('admin.dashboard')}}"
                                }
                            }
                        },
                        error: function (jqXHR) {
                            var response = $.parseJSON(jqXHR.responseText);
                            console.log(jqXHR)

                            if (response.message) {
                                $('#login').find('span.error-response').html(response.message)
                            }
                        }
                    });
                });
                /////// REGISTRATION SCRIPT
                $(document).on('submit','#registerForm', function (e) {
                    e.preventDefault();
                    // console.log('he')
                    var $this = $(this);

                    $.ajax({
                        type: $this.attr('method'),
                        url: "{{  route('frontend.auth.register.post')}}",
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function (data) {
                            $('#first-name-error').empty()
                            $('#last-name-error').empty()
                            $('#email-error').empty()
                            $('#password-error').empty()
                            $('#captcha-error').empty()
                            if (data.errors) {
                                if (data.errors.first_name) {
                                    $('#first-name-error').html(data.errors.first_name[0]);
                                }
                                if (data.errors.last_name) {
                                    $('#last-name-error').html(data.errors.last_name[0]);
                                }
                                if (data.errors.email) {
                                    $('#email-error').html(data.errors.email[0]);
                                }
                                if (data.errors.password) {
                                    $('#password-error').html(data.errors.password[0]);
                                }

                                var captcha = "g-recaptcha-response";
                                if (data.errors[captcha]) {
                                    $('#captcha-error').html(data.errors[captcha][0]);
                                }
                            }
                            if (data.success) {
                                $('#registerForm')[0].reset();
                                $('#register').removeClass('active').addClass('fade')
                                $('.error-response').empty();
                                $('#modal_title').text('Vérification Email')
                                $('#modal_head_link').hide();
                                $('#verification').addClass('active').removeClass('fade')
                                $('.success-response').empty().html("@lang('labels.frontend.modal.registration_message')");

                                if( data.user_uuid) {
                                    data_uuid = data.user_uuid;
                                    url = "{{ route('frontend.auth.account.confirm.resend', ':uuid')}}"
                                    url = url.replace(':uuid', data.user_uuid);
                                    $('#verify_btn').empty().html(`<a href="${url}" class="btn btn-secondary">Renvoyer l'e-mail de confirmation</a>`)
                                    $('#verify_modal_text').empty().html( data.verify_text)

                                }
                                // $('#verification').show();
                                // $('#login').addClass('active').removeClass('fade')

                            }


                        }
                    });
                });
                ////// END REGISTRATION SCRIPT


            });

        });
    </script>
@endpush
