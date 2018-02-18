<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'index', 'show',
        ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::paginate(3));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:posts|max:191',
            'body' => 'required',
        ]);

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = $request->user()->id;
        $post->save();

        return redirect()
            ->route('posts.show', $post->id)
            ->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'comments' => $post->comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (Auth::id() == $post->user_id) {
            return view('posts.edit')->with('post', $post);
        } else {
            return redirect()
                ->route('posts.show', $post->id)
                ->with('error', 'Unauthorized Page'); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (Auth::id() == $post->user_id) {
            $this->validate($request, [
                'title' => 'required|max:191',
                'body' => 'required',
            ]);

            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->save();

            return redirect()
                ->route('posts.show', $post->id)
                ->with('success', 'Post updated');
        } else {
            return redirect()
                ->route('posts.show', $post->id)
                ->with('error', 'Unauthorized Page'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Auth::id() == $post->user_id) {
            $post->delete();
            return redirect()
                ->route('posts.index')
                ->with('success', 'Post deleted');
        } else {
            return redirect()
                ->route('posts.show', $post->id)
                ->with('error', 'Unauthorized Page');
        }
    }
}
