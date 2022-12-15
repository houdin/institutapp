<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;

/**
 * Class AccountController.
 */
class AccountController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.account');
    }
}
