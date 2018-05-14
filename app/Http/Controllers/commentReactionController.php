<?php

namespace App\Http\Controllers;
use App\reactable;
use App\Comment;
use Auth;
use DB;
use App\commentable;
use Illuminate\Http\Request;

class commentReactionController extends Controller
{
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
        $myId = Auth::user()->id;
        $callback = $this->handleStoreValidation($request,$myId);
        if($callback == false)
        {
            $this->handleUpdateInstead($request,$myId);
            return ['success'=>'updated'];
        }
        $reactDB = new reactable;
        $reactDB->type = $request->type;
        $reactDB->user_id = $myId;
        $reactDB->reactable_id = $request->commentID;
        $reactDB->reactable_type = 'App\Comment';
        $reactDB->save();
    }
    protected function handleUpdateInstead($request,$myId)
    {
        reactable::where('reactable_type','App\Comment')->where('reactable_id',$request->commentID)->where('user_id',$myId)->update(['type'=>$request->type]);
    }
    protected function handleStoreValidation($request,$myId)
    {
        $ValidIfZero = reactable::where('reactable_type','App\Comment')->where('reactable_id',$request->commentID)->where('user_id',$myId)->count();
        if($ValidIfZero > 0)
        {
            return false;
        }else
        {
            return true;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($commentId)
    {
       return reactable::where('reactable_type','App\Comment')
       ->where('reactable_id',$commentId)->select('type',DB::raw('count(*) as total'))->groupBy('type')->orderBy('total','DESC')->get(['type']);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($commentID)
    {   
        reactable::where('reactable_type','App\Comment')->where('reactable_id',$commentID)->where('user_id',Auth::user()->id)->delete();
        return ['success'=>'removed'];
    }

    public function getMyReaction($commentID)
    {
        return reactable::where('reactable_type','App\Comment')->where('reactable_id',$commentID)->where('user_id',Auth::user()->id)->value('type');
    }
}
