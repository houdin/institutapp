<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

/**
 * Class ConfirmAccountController.
 */
class ConfirmAccountController extends BaseController
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ConfirmAccountController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param $token
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function confirm($token)
    {
        // dd( $token);

        $this->user->confirm($token);

        return redirect()->route('login')->with('success', __('exceptions.frontend.auth.confirmation.success'));
    }

    /**
     * @param $uuid
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function sendConfirmationEmail($uuid)
    {
        $user = $this->user->findByUuid($uuid);
        // $user = $this->user;

        if ($user->isConfirmed()) {
            return redirect()->route('login')->with('success', __('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        $user->notify(new UserNeedsConfirmation($user->confirmation_code));

        return redirect()->route('login')->with('success', __('exceptions.frontend.auth.confirmation.resent'));
    }
}
