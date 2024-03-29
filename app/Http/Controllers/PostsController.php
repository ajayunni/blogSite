<?php

namespace App\Http\Controllers;

use App\constants\Actions;
use App\Post;
use Facades\App\Repository\posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'profile']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = posts::all('created_at');
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function profile($user_id)
    {
        return view('users.profile', compact('user_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required|min:50',
            'cover_image' => 'image|nullable|max:1999'
        ]);
        //handle file upload
        if ($request->hasFile('cover_image')) {
            //get filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToUpload = $fileName . '_' . time() . '.' . $extension;
            //upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToUpload);
        } else {
            $fileNameToUpload = 'noimage.jpeg';
        }
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToUpload;
        $post->save();

        $historyController = new HistoryController();
        $historyController->store(auth()->user()->id, Actions::ACTION_POST, $post->id);

        return redirect('/posts')->with('success', 'Post created!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Access');
        }
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);
        //handle file upload
        if ($request->hasFile('cover_image')) {
            //get filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToUpload = $fileName . '_' . time() . '.' . $extension;
            //upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToUpload);
        }
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToUpload;
        }
        $post->save();

        $historyController = new HistoryController();
        $historyController->store(auth()->user()->id, Actions::ACTION_POST_EDIT, $id);

        return redirect('/posts')->with('success', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Access');
        }
        $post->comments()->delete();
        $post->likes()->delete();
        $post->delete();

        $historyController = new HistoryController();
        $historyController->store(auth()->user()->id, Actions::ACTION_POST_DELETE, -1);

        return redirect('/posts')->with('success', 'Post deleted!');
    }

}
