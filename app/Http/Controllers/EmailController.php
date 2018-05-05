<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\verificationJob;
use App\UserVerification;
use Auth;
use App\User;
class EmailController extends Controller
{
    public function sendVerificationCode($id)
    {
      $user = User::where('id', $id)->get(['email','fname']);
      $code = UserVerification::where('user_id',$id)->value('code');
      $userdata = array('id' =>$id,'code'=>$code,'email'=>$user[0]->email,'fname'=>$user[0]->fname);
      $userdata = (object)$userdata;
      verificationJob::dispatch($userdata)->delay(now()->addSeconds(5));
      return "successfully sent";
      // return view('emails.verification');
    }
}
