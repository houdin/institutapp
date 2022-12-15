<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

/**
 * Class ContactController.
 */
class ContactController extends BaseController
{

    private $path;

    public function __construct()
    {
    }


    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return Inertia::render('Contact/ContactIndex');
    }

    /**
     * @param SendContactRequest $request
     *
     * @return mixed
     */
    public function send(SendContactRequest $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->number = $request->phone;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        Mail::send(new SendContact($request));
        Session::flash('alert', 'Response received successfully!');



        return redirect()->back();
    }
}
