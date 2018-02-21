<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\Post;
use App\Tag;
use App\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'index', 'show', 'sortByTag',
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
        return view('posts.create')->with('tags', Tag::all());
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

        $post->tags()->attach($request->input('tags'));

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
    public function show(Request $request, Post $post)
    {
        $view = View::where('post_id', $post->id)
                    ->where('visitor', $request->ip())
                    ->first();

        if (!$view) {
            $current_view = new View;
            $current_view->post_id = $post->id;
            $current_view->visitor = $request->ip();
            $current_view->save();

            $post->views++;
            $post->save();
        }

        $is_liked = false;
        $is_disliked = false;

        if (Auth::check()) {
            $record = Like::where('post_id', $post->id)
                          ->where('user_id', Auth::id())->first();
            if ($record) {
                $is_liked = $record->is_liked;
                $is_disliked = $record->is_disliked;
            }
        }

        return view('posts.show', [
            'post' => $post,
            'comments' => $post->comments,
            'is_liked' => $is_liked,
            'is_disliked' => $is_disliked,
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
            return view('posts.edit', [
                'post' => $post,
                'tags' => Tag::all(),
            ]);
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

            $post->tags()->detach();
            $post->tags()->attach($request->input('tags'));

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
    public function destroy(Request $request, Post $post)
    {
        if (Auth::id() == $post->user_id) {
            $post->delete();

            return redirect($request->input('redirectTo'))
                ->with('success', 'Post deleted');
        } else {
            return redirect()
                ->route('posts.show', $post->id)
                ->with('error', 'Unauthorized Page');
        }
    }
    
    public function sortByTag(Tag $tag)
    {
        return view('posts.index')->with('posts', $tag->posts()->paginate(1));
    }

    public function liked(Post $post)
    {
        $record = Like::firstOrCreate([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);

        if (!$record->is_liked && !$record->is_disliked) {
            $record->is_liked = true;
            $post->likes++;
        } elseif (!$record->is_liked && $record->is_disliked) {
            $record->is_liked = true;
            $record->is_disliked = false;
            $post->likes++;
            $post->dislikes--;
        } elseif ($record->is_liked && !$record->is_disliked) {
            $record->is_liked = false;
            $post->likes--;
        }

        $record->save();
        $post->save();

        return redirect()->route('posts.show', $post->id);
    }

    public function disliked(Post $post) 
    {
        $record = Like::firstOrCreate([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);
        
        if (!$record->is_liked && !$record->is_disliked) {
            $record->is_disliked = true;
            $post->dislikes++;
        } elseif (!$record->is_liked && $record->is_disliked) {
            $record->is_disliked = false;
            $post->dislikes--;
        } elseif ($record->is_liked && !$record->is_disliked) {
            $record->is_disliked = true;
            $record->is_liked = false;
            $post->dislikes++;
            $post->likes--;
        }

        $record->save();
        $post->save();

        return redirect()->route('posts.show', $post->id);
    }
}
