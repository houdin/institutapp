<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Models\Auth\User;
use App\Http\Controllers\Backend\BackendBaseController;
use App\Repositories\Backend\Auth\UserRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserPasswordRequest;
use App\Http\Requests\Frontend\User\UpdatePasswordRequest;

/**
 * Class UserPasswordController.
 */
class UserPasswordController extends BackendBaseController
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function edit(ManageUserRequest $request, User $user)
    {

        return view('backend.account.index')
            ->withUser($user);
    }

    /**
     * @param UpdateUserPasswordRequest $request
     * @param string                      $email
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdatePasswordRequest $request, $email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $this->userRepository->updatePassword($user, $request->validated());
            return redirect()->back()->with('success', __('alerts.backend.users.updated_password'));
        } else {
            return redirect()->back()->with('danger', __('exceptions.backend.access.users.update_password_error'));
        }
    }
}
