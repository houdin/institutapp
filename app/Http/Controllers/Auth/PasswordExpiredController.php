<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\User\UpdatePasswordRequest;

/**
 * Class PasswordExpiredController.
 */
class PasswordExpiredController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function expired()
    {
        return view('frontend.auth.passwords.expired');
    }

    /**
     * @param UpdatePasswordRequest $request
     * @param UserRepository        $userRepository
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdatePasswordRequest $request, UserRepository $userRepository)
    {
        $userRepository->updatePassword($request->only('old_password', 'password'), true);

        return redirect()->route('frontend.user.account')->with('success', __('strings.frontend.user.password_updated'));
    }
}
