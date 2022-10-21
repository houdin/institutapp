<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Backend\BackendBaseController;
use App\Http\Requests\Frontend\User\UpdatePasswordRequest;
use App\Repositories\Frontend\Auth\UserRepository;


/**
 * Class UpdatePasswordController.
 */
class UpdatePasswordController extends BackendBaseController
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

        return redirect()->route('admin.account')->with('success', __('strings.frontend.user.password_updated'));
    }
}
