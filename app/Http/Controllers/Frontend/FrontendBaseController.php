<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

/**
 * Class ContactController.
 */
class FrontendBaseController extends Controller
{



    public function __construct()
    {
        App::setLocale(Session::get('frontend-locale'));
    }

}
