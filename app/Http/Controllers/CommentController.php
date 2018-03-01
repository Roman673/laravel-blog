<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        $this->validate($request, [
            'body' => 'required',
        ]);

        // Getting post_id from request
        $post_id = $request->input('post_id');

        // Add comment
        $comment = new Comment;
        $comment->body = $request->input('body');
        $comment->post_id = $post_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        // Gettin post and increment comments counter
        $post = Post::findOrFail($post_id);
        $post->comments++;
        $post->save();

        return redirect()
            ->route('posts.show', $post_id)
            ->with('success', 'Comment created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        if (auth()->user()->id == $comment->user_id) {
            
            // Getting post and decriment comments counter
            $post = $comment->post;
            $post->comments--;
            $post->save();

            // Deleting comment
            $comment->delete();

            return redirect($request->input('redirectTo'))
                    ->with('success', 'Comment deleted');
        } else {
            return redirect()
                ->route('posts.index')
                ->with('error', 'Unauthorized Page');
        }
    }
}
