<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Mail\RegistrationEmail;
use App\Http\Controllers\Frontend\FrontendBaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Helpers\Frontend\Auth\Socialite;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use App\Events\Frontend\Auth\UserRegistered;
use Illuminate\Validation\ClosureValidationRule;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Http\Controllers\Frontend\Auth\ConfirmAccountController;

/**
 * Class RegisterController.
 */
class RegisterController extends FrontendBaseController
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

        return view('frontend.auth.register')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:4|confirmed',
            'g-recaptcha-response' => (false ? ['required', new CaptchaRule] : ''),
        ], [
            'g-recaptcha-response.required' => __('validation.attributes.frontend.captcha'),
        ]);

        if ($validator->passes()) {
            // Store your user in database
            event(new Registered($user = $this->create($request->all())));

            // dd( $user );
            $user->notify(new UserNeedsConfirmation($user->confirmation_code));

            $verify_modal_text = "Un e-mail doit avoir été envoyé à votre adresse à <strong>" . $user->email . "</strong>
                            Il contient des instructions simples pour terminer votre inscription.
                            Si vous continuez à rencontrer des difficultés, contactez l'administrateur du site";

            return response(['success' => true, 'user_uuid' => $user->uuid, 'verify_text' => $verify_modal_text]);
        }

        return response(['errors' => $validator->errors()]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->dob = isset($data['dob']) ? $data['dob'] : NULL;
        $user->phone = isset($data['phone']) ? $data['phone'] : NULL;
        $user->gender = isset($data['gender']) ? $data['gender'] : NULL;
        $user->address = isset($data['address']) ? $data['address'] : NULL;
        $user->city =  isset($data['city']) ? $data['city'] : NULL;
        $user->pincode = isset($data['pincode']) ? $data['pincode'] : NULL;
        $user->state = isset($data['state']) ? $data['state'] : NULL;
        $user->country = isset($data['country']) ? $data['country'] : NULL;
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        // $user->confirmation_code = Hash::make(uniqid(mt_rand(), true));
        $user->save();

        $userForRole = User::find($user->id);
        // $userForRole->confirmation_code = md5(uniqid(mt_rand(), true));
        $userForRole->save();
        $userForRole->assignRole('student');
        // dd( $userForRole);
        // }
        return $user;
    }
}
