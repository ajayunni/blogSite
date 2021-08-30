<?php

namespace App\Http\Controllers;

use App\Comment;
use App\constants\Actions;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
    public function create($post_id, $comment_id)
    {
        return view('comments.create', compact('post_id', 'comment_id'));
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
            'body' => 'required',
        ]);
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_name = auth()->user()->name;
        $comment->post_id = $request->post_id;
        $comment->user_id = auth()->user()->id;
        if ($request->comment_id != null) {
            $comment->parent_id = $request->comment_id;
        }
        $comment->save();

        $historyController = new HistoryController();
        $historyController->store($request->user()->id, Actions::ACTION_COMMENT, $comment->post_id);

        return redirect('/posts/' . $request->post_id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comment::find($id);
        return view('posts.show')->with('comments', $comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);
        if (auth()->user()->id !== $comment->user_id) {
            return redirect('/posts/' . $comment->post_id)->with('error', 'Unauthorized Access');
        }

        return view('comments.edit', compact('comment'));
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
            'body' => 'required',
        ]);
        $comment = Comment::find($id);
        $comment->body = $request->input('body');
        $comment->save();

        $historyController = new HistoryController();
        $historyController->store(auth()->user()->id, Actions::ACTION_COMMENT_EDIT, $comment->post_id);

        return redirect('/posts/' . $comment->post_id)->with('success', 'comment updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (auth()->user()->id !== $comment->user_id) {
            return redirect('/posts/' . $comment->post_id)->with('error', 'Unauthorized Access');
        }
        $comment->deleteRelatedData();
        $comment->delete();

        $historyController = new HistoryController();
        $historyController->store(auth()->user()->id, Actions::ACTION_COMMENT_DELETE, -1);

        return redirect('/posts/' . $comment->post_id)->with('success', 'Comment deleted!');
    }
}
