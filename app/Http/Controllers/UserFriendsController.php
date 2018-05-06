<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserFriend;
use Auth;
class UserFriendsController extends Controller
{
    public function storeRequest(Request $request)
    {
      $sentcount=$this->FriendRequestValidation($request);
      if($sentcount > 0)
      {
        return response()->json(['error'=>'You already sent a friend request'],404);
      }
      $userFriendDB = new userFriend;
      $userFriendDB->user_idf = Auth::user()->id;
      $userFriendDB->user_ids = $request->userid;
      $userFriendDB->save();
      return ['success'=>'success'];
    }
    protected function FriendRequestValidation($request)
    {
       return userFriend::where('user_idf', Auth::user()->id)
      ->where('user_ids', $request->userid)
      ->orWhere('user_idf',$request->userid)
      ->where('user_ids', Auth::user()->id)->count();
    }
    public function acceptRequest(Request $request)
    {
      $countResult = $this->acceptValidation($request);
      if($countResult > 0)
      {
        return response()->json(['error'=>'You are already friends with this person']);
      }
      $requestRowData = userFriend::where('user_idf', Auth::user()->id)
     ->where('user_ids', $request->userid)->whereNull('isFriends')
     ->orWhere('user_idf',$request->userid)
     ->where('user_ids', Auth::user()->id)->whereNull('isFriends')
     ->get();
     if(count($requestRowData) > 1)
     {
      return response()->json(['error'=>'You are already friends with this person']);
     }
     $this->handleUpdateAsAccepted($request);
     $this->handleSavingFriendship($request);
    }

    protected function handleUpdateAsAccepted($request)
    {
      userFriend::where('user_idf', $request->userid)
     ->where('user_ids', Auth::user()->id)->whereNull('isFriends')->update(['isFriends'=>'0']);
    }
    protected function handleSavingFriendship($request)
    {
      $friendDB = new userFriend;
      $friendDB->user_idf = Auth::user()->id;
      $friendDB->user_ids = $request->userid;
      $friendDB->isFriends = '0';
      $friendDB->save();
    }
    protected function acceptValidation(Request $request)
    {
      return userFriend::where('user_idf', Auth::user()->id)
     ->where('user_ids', $request->userid)->where('isFriends', '0')
     ->orWhere('user_idf',$request->userid)
     ->where('user_ids', Auth::user()->id)->where('isFriends', '0')
     ->count();
    }
}
