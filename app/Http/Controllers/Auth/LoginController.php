<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\GeneralException;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Auth\Auth as AuthHelper;
use App\Helpers\Frontend\Auth\Socialite;
use Illuminate\Support\Facades\Validator;
use App\Events\Frontend\Auth\UserLoggedIn;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use App\Events\Frontend\Auth\UserLoggedOut;
use App\Repositories\Frontend\Auth\UserSessionRepository;


/**
 * Class LoginController.
 */
class LoginController extends BaseController
{
    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showModal()
    {
        if (request()->ajax()) {
            return ['socialLinks' => (new Socialite)->getSocialLinks()];
        }
        // dd(request());
        return response()->json([
            'show_modal' => true
        ]);
        // return redirect('/')->with('show_login', true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (request()->ajax()) {
            return ['socialLinks' => (new Socialite)->getSocialLinks()];
        }
        // dd(request());
        // return redirect('/')->with('show_login', true);
        return view('frontend.layouts.app');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return config('access.users.username');
    }



    public function login(Request $request)
    {
        dd($request);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',
            'g-recaptcha-response' => (false ? ['required', new CaptchaRule] : ''),
        ], [
            'g-recaptcha-response.required' => __('validation.attributes.frontend.captcha'),
        ]);

        if ($validator->passes()) {

            $credentials = $request->only($this->username(), 'password');
            $authSuccess = Auth::attempt($credentials, $request->has('remember'));

            if ($authSuccess) {
                $request->session()->regenerate();
                if (Auth::user()->active > 0) {
                    if (Auth::user()->isAdmin()) {
                        $redirect = 'back';
                        // $redirect = 'dashboard';
                    } else {
                        $redirect = 'back';
                    }
                    return response(['success' => true, 'redirect' => $redirect, 'user' => Auth::user()], Response::HTTP_OK);
                } else {
                    Auth::logout();

                    return
                        response([
                            'success' => false,
                            'message' => 'Login failed. Account is not active'
                        ], Response::HTTP_FORBIDDEN);
                }
            } else {
                return
                    response([
                        'success' => false,
                        'message' => 'Login failed. Account not found'
                    ], Response::HTTP_FORBIDDEN);
            }
        }


        return response(['success' => false, 'errors' => $validator->errors()]);
    }





    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param         $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws GeneralException
     */
    protected function authenticated(Request $request, $user)
    {
        /*
         * Check to see if the users account is confirmed and active
         */
        if (!$user->isConfirmed()) {
            Auth::logout();

            // If the user is pending (account approval is on)
            if ($user->isPending()) {
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
            }

            // Otherwise see if they want to resent the confirmation e-mail

            throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', ['url' => route('frontend.auth.account.confirm.resend', $user->{$user->getUuidName()})]));
        } elseif (!$user->isActive()) {
            Auth::logout();
            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }

        event(new UserLoggedIn($user));

        // If only allowed one session at a time
        if (config('access.users.single_login')) {
            resolve(UserSessionRepository::class)->clearSessionExceptCurrent($user);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user_name = Auth::user()->first_name;
        /*
         * Remove the socialite session variable if exists
         */
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }

        /*
         * Remove any session data from backend
         */
        app()->make(AuthHelper::class)->flushTempSession();

        /*
         * Fire event, Log out user, Redirect
         */
        event(new UserLoggedOut($request->user()));

        /*
         * Laravel specific logic
         */
        $this->guard()->logout();
        $request->session()->invalidate();

        // return ['message' => $user_name . ', Vous êtes déconnecté. '];
        // if (request()->ajax()) {
        // }

        return redirect()->route('frontend.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id
            $admin_id = session()->get('admin_user_id');

            app()->make(AuthHelper::class)->flushTempSession();

            // Re-login admin
            Auth::loginUsingId((int) $admin_id);

            // Redirect to backend user page
            return redirect()->route('admin.auth.user.index');
        } else {
            app()->make(AuthHelper::class)->flushTempSession();

            // Otherwise logout and redirect to login
            Auth::logout();

            return redirect()->route('login');
        }
    }
}
