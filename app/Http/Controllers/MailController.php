<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public static function sendRegistrationEmail($name, $email, $confirmation_code)
    {
        $data = [
            'name' => $name,
            'to' => $email,
            'from' => 'houdini.hamed@gmail.com',
            'confirmation_code' => $confirmation_code,
            'subject' => 'Inscription',
            'messagenote' => 'My registration is cool'
        ];
        $registrationEmail = new RegistrationEmail( $data ) ;
        dd( $registrationEmail);
        Mail::to( $data['to'] )->send( $registrationEmail );
    }
}
