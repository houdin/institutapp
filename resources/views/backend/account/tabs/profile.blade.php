<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>Avatar</th>
            <td><img src="{{ $user->picture }}" height="100px" class="user-profile-image" /></td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td>{{ $user->email }}</td>
        </tr>
        @if($logged_in_user->hasRole('teacher'))
            <tr>
                <th>Status</th>
                <td>{!! $logged_in_user->status_label !!}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{!! $logged_in_user->gender !!}</td>
            </tr>
            @php
                $teacherProfile = $logged_in_user->teacherProfile?:'';
                $payment_details = $logged_in_user->teacherProfile?json_decode($logged_in_user->teacherProfile->payment_details):new stdClass();
            @endphp
            <tr>
                <th>Facebook link</th>
                <td>{!! $teacherProfile->facebook_link !!}</td>
            </tr>
            <tr>
                <th>Twitter link</th>
                <td>{!! $teacherProfile->twitter_link !!}</td>
            </tr>
            <tr>
                <th>Linkedin link</th>
                <td>{!! $teacherProfile->linkedin_link !!}</td>
            </tr>
            <tr>
                <th>Payment Details</th>
                <td>{!! $teacherProfile->payment_method !!}</td>
            </tr>
            @if($payment_details)
                @if($teacherProfile->payment_method == 'bank')
                <tr>
                    <th>Bank Name</th>
                    <td>{!! $payment_details->bank_name !!}</td>
                </tr>
                <tr>
                    <th>IFSC Code</th>
                    <td>{!! $payment_details->ifsc_code !!}</td>
                </tr>
                <tr>
                    <th>Account Number</th>
                    <td>{!! $payment_details->account_number !!}</td>
                </tr>
                <tr>
                    <th>Account Name</th>
                    <td>{!! $payment_details->account_name !!}</td>
                </tr>
                @else
                <tr>
                    <th>Paypal Email</th>
                    <td>{!! $payment_details->paypal_email !!}</td>
                </tr>
                @endif
            @endif
        @endif

        <tr>
            <th>Created At</th>
            <td>{{ timezone()->convertToLocal($user->created_at) }} ({{ $user->created_at->diffForHumans() }})</td>
        </tr>
        <tr>
            <th>Last Updated</th>
            <td>{{ timezone()->convertToLocal($user->updated_at) }} ({{ $user->updated_at->diffForHumans() }})</td>
        </tr>
        @if(config('registration_fields') != NULL)
            @php
                $fields = json_decode(config('registration_fields'));
            @endphp
            @foreach($fields as $item)
                <tr>
                    <th>{{__('backend/labels.backend.general_settings.user_registration_settings.fields.'.$item->name)}}</th>
                    <td>{{$user[$item->name]}}</td>
                </tr>
            @endforeach
        @endif
    </table>
</div>
