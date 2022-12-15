<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

/**
 * Class ContactController.
 */
class BaseController extends Controller
{



    public function __construct()
    {
        App::setLocale(Session::get('frontend-locale'));
    }
}
