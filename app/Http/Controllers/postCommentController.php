<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Auth;
use App\Post;
use Carbon\Carbon;
use App\commentable;
class postCommentController extends Controller
{
    public function __constructor()
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
        $this->handleCommentValidation($request);

        $commentDB = new Comment;
        $commentDB->content = $request->content;
        $commentDB->user_id = Auth::user()->id;
        $commentDB->save();

        $commentableDB  = new commentable;
        $commentableDB->comment_id = $commentDB->id;
        $commentableDB->commentable_id=$request->postid;
        $commentableDB->commentable_type='App\Post';
        $commentableDB->save();
        return response()->json(['id'=>$commentDB->id]);
    }
    protected function handleCommentValidation($request)
    {
        $this->validate($request,[
            'content'=>'required|max:190'
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
        return Comment::where('id',$id)->with('CommentOwner')->get();
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
       commentable::where('comment_id',$id)->delete();
       Comment::where('id',$id)->delete();
    }

    public function getCommentsOfPost($postid)
    {
       $postdata=Post::find($postid);
       $comments = $postdata->comments()->orderBy('comments.id','DESC')->paginate(4,['comments.id']);
       $comments = (object)$comments;
        return response()->json($comments);
    }

    public function countPostComments($postid)
    {
        $postdata=Post::find($postid);
       $comments = $postdata->comments()->orderBy('comments.id','DESC')->count();
    }
}
