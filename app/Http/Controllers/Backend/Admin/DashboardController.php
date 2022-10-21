<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Requests;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendBaseController;

class DashboardController extends BackendBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home');
    }
}
