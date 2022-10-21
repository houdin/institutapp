<?php

namespace App\Http\Controllers\Backend\Admin;



use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendBaseController;

class AbstractAdminController extends BackendBaseController
{
    /**
     * AdminHomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.admin');
    }
}
