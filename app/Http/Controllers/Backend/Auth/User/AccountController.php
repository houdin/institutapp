<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;

/**
 * Class AccountController.
 */
class AccountController extends BackendBaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        return view('backend.account.index',compact('user'));
    }
}
