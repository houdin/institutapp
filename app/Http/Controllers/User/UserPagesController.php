<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\BaseController;
use Illuminate\View\View;
use Psy\Util\Json;

abstract class UserPagesController extends BaseController
{
    /**
     * @var array
     */
    protected $allowed = [];

    /**
     * @var string
     */
    protected $redirect = '/';

    /**
     * checks if the parameter is allowed if not it will return to the redirect page
     *
     * @param $value
     * @return \Illuminate\Http\RedirectResponse | View | Json
     */
    protected function isAllowed($value)
    {
        if (in_array($value, $this->allowed)) {
            return $this->onSuccess();
        }
        return redirect($this->redirect);
    }

    /**
     * @param $error
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function hasError($error)
    {
        session()->flash('error', $error);
        return redirect($this->redirect);
    }
}
