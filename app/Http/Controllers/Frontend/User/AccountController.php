<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Frontend\FrontendBaseController;

/**
 * Class AccountController.
 */
class AccountController extends FrontendBaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.account');
    }
}
