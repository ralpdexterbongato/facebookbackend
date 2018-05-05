<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
class UserService extends Controller
{
    public function refreshLastPostTime($id)
    {
      $currentTime=Carbon::now();
      User::where('id', $id)->update(['lastposttime'=>$currentTime]);
    }
}
