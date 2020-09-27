<?php

namespace App\Http\Controllers;
use App\like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
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
        $liked=false;
        foreach (Post::find($request->input('post_id'))->likes as $like){
            if($like->user_id==auth()->user()->id){
                $liked=true;
                $id = $like->id;
                break;
            }
        }
        if ($liked){
            $like = like::find($id);
            $like->delete();
            return redirect('/posts/'.$request->input('post_id'))->with('success','disliked ☹');
        }
        $like = new like();
        $like->post_id = $request->input('post_id');
        $like->user_id = auth()->user()->id;
        $like->user_name = $request->input('user_name');
        $like->save();
        return redirect('/posts/'.$request->input('post_id'))->with('success','liked 😍');
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
        //
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
}
