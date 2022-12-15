<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;

/**
 * Class ProfileController.
 */
class ProfileController extends BaseController
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdateProfileRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateProfileRequest $request)
    {
        $output = $this->userRepository->update(
            $request->user()->id,
            $request->only('first_name', 'last_name', 'email', 'avatar_type', 'avatar_location'),
            $request->has('avatar_location') ? $request->file('avatar_location') : false
        );

        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            auth()->logout();

            return redirect()->route('login')->with('info', __('strings.frontend.user.email_changed_notice'));
        }

        return redirect()->route('frontend.user.account')->with('success', __('strings.frontend.user.profile_updated'));
    }
}
