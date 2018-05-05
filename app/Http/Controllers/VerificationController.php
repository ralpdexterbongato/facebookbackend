<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserVerification;
class VerificationController extends Controller
{
    public function verifyme(Request $request)
    {
      $code = UserVerification::where('code', $request->code)->where('id', $request->id)->take(1)->get();
      if(!empty($code[0]))
      {
        User::where('id',$request->id)->whereNull('isverified')->update(['isverified'=>0]);
        return redirect('//127.0.0.1:4200/verified');
      }else
      {
        return redirect('//127.0.0.1:4200/home');
      }
    }
}
