<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

/**
 * Class ContactController.
 */
class BackendBaseController extends Controller
{

    public function __construct()
    {
        App::setLocale(Session::get('backend-locale'));
    }

}
