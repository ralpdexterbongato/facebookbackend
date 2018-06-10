<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use App\User;
use Carbon\Carbon;
use App\taggable;
use App\Http\Controllers\Services\UserService;
class PostController extends Controller
{
    public function __construct(UserService $userservice)
    {
      $this->userservice = $userservice;
      $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->handleStoreValidation($request);
      $posterId =Auth::user()->id;
      $postDB = new Post;
      $postDB->user_id= $posterId;
      $postDB->description = $request->description;
      $postDB->background = $request->background;
      $postDB->userfile = '';
      $postDB->privacy = $request->privacy;
      $postDB->save();
      $this->handleSavingTags($request,$postDB->id);
      $this->userservice->refreshLastPostTime($posterId);
      return ['postid'=>$postDB->id];
    }
    protected function handleSavingTags($request,$contentID)
    {
      $creatorID =Auth::user()->id;
      $taginfos=[];
      foreach ($request->taggedUsers as $key => $user)
      {
        $taginfos[] = array('user_id' =>$user,'creator_id'=>$creatorID,'taggable_id'=>$contentID,'taggable_type'=>'App\Post' );
      }
      // hidden tag for the poster
      $taginfos[] = array('user_id' =>$creatorID,'creator_id'=>$creatorID,'taggable_id'=>$contentID,'taggable_type'=>'App\Post' );
      taggable::insert($taginfos);
    }
    protected function handleStoreValidation($request)
    {
      $this->validate($request,[
        'description'=>'max:191',
        'background'=>'max:2',
        'privacy'=>'required|max:1'
      ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::where('id',$id)->with('Poster')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Post::where('id',$id)->update(['description'=>$request->description]);
        return ['success'=>'success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Post::where('id',$id)->delete();
       return ['success'=>'removed successly'];
    }

    public function profilePost($id)
    {
      return taggable::where('user_id',$id)->orderBy('id','DESC')->paginate(1,['id']);
    }
    public function getMyNewlySubmitted($id)
    {
      return taggable::where('creator_id',Auth::user()->id)->where('user_id',$id)->orderBy('id','DESC')->take(1)->get(['id']);
    }
    public function getTopFriendsWithNewPost()
    {
      $myid = Auth::user()->id;
      $me = User::find($myid);
      return $me->friends()->orderBy('lastposttime','DESC')->paginate(1,['users.id','lastposttime']);
    }
    public function newsFeedPosts($friendID)
    {
      $friendData = User::find($friendID);
      $friendIds = $friendData->TaggedPostsNewOnly()->paginate(3,['posts.id']);
      return response()->json($friendIds);
    }
}
