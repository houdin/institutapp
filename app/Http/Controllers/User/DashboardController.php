<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController.
 */
class DashboardController extends BaseController
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
