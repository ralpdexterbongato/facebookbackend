<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserFriend;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use App\Post;
class UserFriendsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:api');
    }
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
      $friendDB->isSeen='0';
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
    public function ignoreCancelRequest($otherUserId)
    {
      $myId = Auth::user()->id;
      userFriend::where('user_idf',$myId)->where('user_ids',$otherUserId)->whereNull('isFriends')->orWhere('user_idf',$otherUserId)->where('user_ids',$myId)->whereNull('isFriends')->delete();
      return ['success'=>'success'];
    }
    public function unfriendUser($otherid)
    {
      $myid = Auth::user()->id;
      UserFriend::where('user_idf',$myid)->where('user_ids',$otherid)->orWhere('user_idf',$otherid)->where('user_ids',$myid)->whereNotNull('isFriends')->delete();
      return ['success'=>'success'];
    }
    public function PreviewUserFriends($id)
    {
      $userdata =  User::find($id);
      return $userdata->friends()->orderBy('user_friends.id','DESC')->where('users.id','!=',$id)->take(9)->get(['users.id','fname','lname','gender']);
    }
    public function countfriendNewPost($userid)
    {
      $time = Carbon::now()->subSeconds(1000);
      return Post::where('user_id',$userid)->where('created_at','>',$time)->count();
    }
    public function getFriendRequest()
    {
       $myid = Auth::user()->id;
       $me = User::find($myid);
       $friendrequests = $me->friendRequestReceived()->orderBy('user_friends.id','DESC')->whereNull('isFriends')->paginate(9,['users.id','gender','fname','lname','isSeen']);
       return $friendrequests;
    }
    public function countFriendRequest()
    {
       $myid = Auth::user()->id;
       $me = User::find($myid);
       return $me->friendRequestReceived()->whereNull('isFriends')->whereNull('isSeen')->count();
    }
    public function updateAllToSeen()
    {
       $myid = Auth::user()->id;
       UserFriend::whereNull('isFriends')->where('user_ids',$myid)->whereNull('isSeen')->update(['isSeen'=>'0']);
    }
    public function searchSuggestion(Request $request)
    {
      $myid = Auth::user()->id;
      $me = User::find($myid);
      $suggestions = $me->friends()->where(DB::raw("CONCAT(fname,lname)"),'%'.$request->q.'%')->take(5)->get(['users.id','fname','lname']);
      return $suggestions;
    }
}
