<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RegisterValidationController extends Controller
{
    /**
     * responds to an ajax request to check if a email is taken
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function email(Request $request)
    {

        $this->validate($request, [
            'email' => 'email'
        ]);
        $count = (User::where('email', $request->input('email'))->count() === 0) ? true : false;

        return response()->json([
            'email' => $count
        ], 200);
    }
    public function email2(Request $request)
    {
        # code...
    }

    /**
     * responds to an ajax request to check if a user name is taken
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function username(Request $request)
    {
        $count = (User::where('username', $request->input('username'))->count() === 0) ? true : false;

        return response()->json([
            'username' => $count
        ], 200);
    }
}
