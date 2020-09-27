<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
        //
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
    public function update(Request $request)
    {
        $this->validate($request,[
            'profile_image'=>'image|nullable|max:1999'
        ]);
        $this->destroy($request->input('user_id'));
        //handle file upload
        if ($request->hasFile('profile_image')){
            //get filename with extension
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            //get just filename
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just extension
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToUpload = $fileName.'_'.time().'.'.$extension;
            //upload the image
            $path = $request->file('profile_image')->storeAs('public/profile_images',$fileNameToUpload);
        }
        $user = User::find($request->input('user_id'));
        if ($request->hasFile('profile_image')){
            $user->profile_image = $fileNameToUpload;
        }
        $user->save();
        return redirect('/home')->with('success','Profile Pic Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->profile_image!='') {
            Storage::delete('public/profile_images/'.$user->profile_image);
        }
    }
}
