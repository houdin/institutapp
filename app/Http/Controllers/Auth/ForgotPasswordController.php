<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * Class ForgotPasswordController.
 */
class ForgotPasswordController extends BaseController
{
    //use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('frontend.auth.passwords.email');
    }
}
