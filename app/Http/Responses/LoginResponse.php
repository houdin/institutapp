<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {

        if ($request->redirect) {
            return redirect($request->redirect)->with('modal', ['open' => false, 'type' => '']);
        }
        // return redirect()->route('admin.dashboard');
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->back();
        // : redirect()->intended(config('fortify.home')); // This is the line you want to modify so the application behaves the way you want.
    }
}
