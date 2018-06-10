<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\commentable;
use Auth;
use Carbon\Carbon;
class ReplyController extends Controller
{
    public function __construct()
    {
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
        $commentDB = new Comment;
        $commentDB->content = $request->content;
        $commentDB->user_id = Auth::user()->id;
        $commentDB->save();

        $commentableDB = new commentable;
        $commentableDB->comment_id = $commentDB->id;
        $commentableDB->commentable_id = $request->mainCommentID;
        $commentableDB->commentable_type='App\Comment';
        $commentableDB->save();

        return response()->json(['id'=>$commentDB->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comment::where('id',$id)->with('CommentOwner')->get(['id','content','user_id','updated_at','isUpdated']);
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
    public function update(Request $request, $commentid)
    {
         Comment::where('id',$commentid)->update(['content'=>$request->content,'isUpdated'=>'0','updated_at'=>Carbon::now()]);
         return ['success'=>'updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getRepliesOfComments($mainCommentId)
    {
        $commentDB = Comment::find($mainCommentId);
        return $commentDB->replies()->orderBy('comments.id','DESC')->paginate('4',['comments.id']);
    }

    public function getLatestReply($mainCommentID)
    {
        $commentDB = Comment::find($mainCommentID);
        return $commentDB->replies()->with('CommentOwner')->orderBy('comments.id','DESC')->take(1)->get();
    }
}
