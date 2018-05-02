<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\verificationJob;
class EmailController extends Controller
{
    public function sendVerificationCode()
    {
      // verificationJob::dispatch()->delay(now()->addSeconds(5));
      // return "successfully sent";
      return view('emails.verification');
    }
}
