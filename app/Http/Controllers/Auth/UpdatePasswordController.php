<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Frontend\User\UpdatePasswordRequest;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;

class UpdatePasswordController extends BaseController
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ChangePasswordController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdatePasswordRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdatePasswordRequest $request)
    {
        $this->userRepository->updatePassword($request->only('old_password', 'password'));

        return redirect()->route('frontend.user.account')->with('success', __('strings.frontend.user.password_updated'));
    }
}
