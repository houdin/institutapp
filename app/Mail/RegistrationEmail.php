<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( 'houdini.hamed@gmail.com' )
            // ->subject('Inscription ')
            ->view('emails.registration_email')->with('data', $this->data);
            // ->text('frontend.mail.contact-text')
            // ->replyTo($this->email_data->email, $this->email_data->name);
    }
}
