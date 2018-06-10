<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;
use Auth;
use App\reactable;
class postReactController extends Controller
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
        $myID = Auth::user()->id;
        $isValid = $this->handleStoreValidation($request,$myID);

        if($isValid == false)
        {
         $this->updateIfExist($request,$myID);
         return ['success'=>'updated'];
        }

        $reactableDB = new reactable;
        $reactableDB->user_id = $myID;
        $reactableDB->type = $request->type;
        $reactableDB->reactable_id = $request->postID;
        $reactableDB->reactable_type = 'App\Post';
        $reactableDB->save();

        return response()->json(['success'=>'success']);
    }
    protected function handleStoreValidation($request,$myID)
    {    
        $IfZeroValid = reactable::where('reactable_type','App\Post')->where('reactable_id',$request->postID)->where('user_id',$myID)->count();
        if($IfZeroValid == 0)
        {
            return true;
        }else
        {
            return false;
        }
    }
    protected function updateIfExist($request,$myID)
    {
        reactable::where('reactable_type','App\Post')->where('reactable_id',$request->postID)->where('user_id',$myID)->update(['type'=>$request->type]);
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        reactable::where('reactable_type','App\Post')->where('reactable_id',$id)->where('user_id',Auth::user()->id)->delete();
        return ['success'=>'success'];
    }
    public function countReacts($postId)
    {
       return reactable::where('reactable_type','App\Post')->where('reactable_id',$postId)->select('type', DB::raw('count(*) as total'))->orderBy('total','DESC')
                 ->groupBy('type')->get(['type']);
    }
    public function getMyReactionToPost($postId)
    {
        $myid = Auth::user()->id;
        return reactable::where('reactable_type','App\Post')->where('user_id',$myid)->where('reactable_id',$postId)->value('type');
    }

}
