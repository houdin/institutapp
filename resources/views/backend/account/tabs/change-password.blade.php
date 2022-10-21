{{ html()->form('PATCH', route('admin.account.post',$user->email))->class('form-horizontal')->open() }}

@if(!Route::is('admin.auth.user.change-password', $user) && Route::is('admin.account'))
<div class="row">
        <div class="col">
            <div class="form-group">
                {{ html()->label(__('backend/validation.attributes.frontend.old_password'))->for('old_password') }}

                {{ html()->password('old_password')
                    ->class('form-control')
                    ->placeholder(__('backend/validation.attributes.frontend.old_password'))
                    ->autofocus()
                    ->required() }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->
@endif

    <div class="row">
        <div class="col">
            <div class="form-group">
                {{ html()->label(__('backend/validation.attributes.frontend.new_password'))->for('password') }}

                {{ html()->password('password')
                    ->class('form-control')
                    ->placeholder(__('backend/validation.attributes.frontend.new_password'))
                    ->required() }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group">
                {{ html()->label(__('backend/validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                {{ html()->password('password_confirmation')
                    ->class('form-control')
                    ->placeholder(__('backend/validation.attributes.frontend.password_confirmation'))
                    ->required() }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group mb-0 clearfix">
                {{ form_submit(__('backend/labels.general.buttons.update') . ' ' . __('backend/validation.attributes.frontend.password')) }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->
{{ html()->form()->close() }}
