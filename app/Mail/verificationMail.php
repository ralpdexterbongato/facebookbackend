<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class verificationMail extends Mailable
{
    public $userdata;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userdata)
    {
        $this->userdata = $userdata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verification')->subject("Verify your account")->from("rdc2898@gmail.com")->with([
                    'user' => $this->userdata,
                  ]);;
    }
}
