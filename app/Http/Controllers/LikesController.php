<?php

namespace App\Http\Controllers;

use App\constants\Actions;
use App\Dislike;
use App\like;
use App\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    //Bypass login
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('isLike') == false) {
            return $this->dislikeAction($request);
        }
        $this->destroyDisLike($request);
        $liked = false;
        foreach (Post::find($request->input('post_id'))->likes as $like) {
            if ($like->user_id == auth()->user()->id) {
                $liked = true;
                break;
            }
        }
        if ($liked) {
            return redirect('/posts/' . $request->input('post_id'))
                ->with('error', 'you already liked (⌐■_■)');
        }
        $like = new like();
        $like->post_id = $request->input('post_id');
        $like->user_id = auth()->user()->id;
        $like->user_name = $request->input('user_name');
        $like->save();

        $historyController = new HistoryController();
        $historyController->store($request->user()->id, Actions::ACTION_LIKE, $like->post_id);

        return redirect('/posts/' . $request->input('post_id'))->with('success', 'liked ( ͡• ͜ʖ ͡• )');
    }

    /**
     * Dislikes
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function dislikeAction(Request $request)
    {
        $this->destroyLike($request);
        $disLiked = false;
        foreach (Post::find($request->input('post_id'))->dislikes as $dislike) {
            if ($dislike->user_id == auth()->user()->id) {
                $disLiked = true;
                break;
            }
        }
        if ($disLiked) {
            return redirect('/posts/' . $request->input('post_id'))
                ->with('error', 'you already disliked ¯\_(ツ)_/¯');
        }
        $dislike = new Dislike();
        $dislike->post_id = $request->input('post_id');
        $dislike->user_id = auth()->user()->id;
        $dislike->user_name = $request->input('user_name');
        $dislike->save();

        $historyController = new HistoryController();
        $historyController->store($request->user()->id, Actions::ACTION_DISLIKE, $dislike->post_id);

        return redirect('/posts/' . $request->input('post_id'))->with('success', 'disliked (╯°□°）╯︵ ┻━┻');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroyLike(Request $request): bool
    {
        foreach (Post::find($request->input('post_id'))->likes as $like) {
            if ($like->user_id == auth()->user()->id) {
                $like->delete();
                return true;
            }
        }
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroyDisLike(Request $request): bool
    {
        foreach (Post::find($request->input('post_id'))->dislikes as $dislike) {
            if ($dislike->user_id == auth()->user()->id) {
                $dislike->delete();
                return true;
            }
        }
        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
