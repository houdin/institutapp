    @extends('backend.layouts.app')

    @section('content')
        <div class="row justify-content-center align-items-center mb-3">
            <div class="col col-sm-12 align-self-center">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Edit Account</h3>
                    </div>

                    <div class="card-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="profile-tab" data-coreui-toggle="tab"
                                        data-coreui-target="#profile" type="button" role="tab" aria-controls="profile"
                                        aria-selected="true">
                                        Profile</button>
                                    {{-- <a href="#profile" class="nav-link active" aria-controls="profile" role="tab"
                                        data-toggle="tab" aria-selected="true">Profile</a> --}}
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="edit-tab" data-coreui-toggle="tab"
                                        data-coreui-target="#edit" type="button" role="tab" aria-controls="edit"
                                        aria-selected="true">
                                        Update Information</button>
                                    {{-- <a href="#edit" class="nav-link" aria-controls="edit" role="tab" data-toggle="tab"
                                        aria-selected="false">Update Information</a> --}}
                                </li>

                                @if ($user->canChangePassword())
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="password-tab" data-coreui-toggle="tab"
                                            data-coreui-target="#password" type="button" role="tab" aria-controls="password"
                                            aria-selected="true">
                                            Change Password</button>
                                        {{-- <a href="#password" class="nav-link" aria-controls="password" role="tab"
                                            data-toggle="tab" aria-selected="false">Change Password</a> --}}
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active pt-3" id="profile"
                                    aria-labelledby="profile-tab">
                                    @include('backend.account.tabs.profile')
                                </div>
                                <!--tab panel profile-->

                                <div role="tabpanel" class="tab-pane fade show pt-3" id="edit" aria-labelledby="edit-tab">
                                    @include('backend.account.tabs.edit')
                                </div>
                                <!--tab panel profile-->

                                @if ($user->canChangePassword())
                                    <div role="tabpanel" class="tab-pane fade show pt-3" id="password"
                                        aria-labelledby="password-tab">
                                        @include('backend.account.tabs.change-password')
                                    </div>
                                    <!--tab panel change password-->
                                @endif
                            </div>
                            <!--tab content-->
                        </div>
                        <!--tab panel-->
                    </div>
                    <!--card body-->
                </div><!-- card -->
            </div><!-- col-xs-12 -->
        </div><!-- row -->
    @endsection
