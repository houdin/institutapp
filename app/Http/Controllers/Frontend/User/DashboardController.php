<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Frontend\FrontendBaseController;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController.
 */
class DashboardController extends FrontendBaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Auth::routes(['verify' => true]);
        return view('frontend.user.dashboard');
    }
}
