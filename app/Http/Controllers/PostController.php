<?php

namespace App\Http\Controllers;

use App\Dislike;
use App\Comment;
use App\Like;
use App\Post;
use App\Tag;
use App\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private static $paginate = 3; 

    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'index',
            'show',
            'sortByTag',
            'orderByCreated',
            'orderByViews',
            'orderByLikes',
            'orderByComments',
        ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        // Checking the existence of a query
        if ($request->input('q')) {
            $q = $request->input('q');
            $posts = Post::where('title', 'like', '%'.$q.'%')
                           ->orderBy('title', 'asc')
                           ->paginate(self::$paginate);
        } else {
            $posts = Post::orderBy('title', 'asc')->paginate(self::$paginate);
        }
        
        return view('posts.index', [
            'posts' => $posts,
            'title' => 'Posts',
            'breadcrumbs' => [
                ['Home', '/'],
                ['Posts', ''],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
            'tags' => Tag::all(),
            'title' => 'Creating post',
            'breadcrumbs' => [
                ['Home', '/'],
                ['Creating post', ''],
            ],
        ]);
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
            'cover_image' => 'image|nullable|max:1999',
        ]);

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = $request->user()->id;

        if ($request->hasFile('cover_image')) {
            // Create file name like 707209956.jpg
            $filename = rand() . '.' . $request->file('cover_image')->getClientOriginalExtension();
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filename);        
            $post->cover_image = $filename;
        }

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
            View::create(['post_id' => $post->id, 'visitor' => $request->ip()]);
            $post->views++;
            $post->save();
        }

        $is_liked = 0;
        $is_disliked = 0;

        if (auth()->check()) {
            $is_liked = Like::where('post_id', $post->id)
                            ->where('user_id', auth()->user()->id)
                            ->count();
            $is_disliked = Dislike::where('post_id', $post->id)
                                  ->where('user_id', auth()->user()->id)
                                  ->count();
        }

        return view('posts.show', [
            'post' => $post,
            'is_liked' => $is_liked,
            'is_disliked' => $is_disliked,
            'title' => $post->title,
            'breadcrumbs' => [
                ['Home', '/'],
                ['Posts', '/posts'],
                [$post->title, ''],
            ],
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
        if (auth()->user()->id == $post->user_id) {
            return view('posts.edit', [
                'post' => $post,
                'tags' => Tag::all(),
                'title' => "Edit $post->title",
                'breadcrumbs' => [
                    ['Home', '/'],
                    ['Posts', '/posts'],
                    [$post->title, "/posts/$post->id"],
                    ["Edit $post->title", ''],
                ],
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
        if (auth()->user()->id == $post->user_id) {
            $this->validate($request, [
                'title' => 'required|max:191',
                'body' => 'required',
                'cover_image' => 'image|nullable|max:1999',
            ]);

            if ($request->hasFile('cover_image')) {
                // Create file name like 707209956.jpg
                $filename = rand() . '.' . $request->file('cover_image')->getClientOriginalExtension();
                $path = $request->file('cover_image')->storeAs('public/cover_images', $filename);        
                $post->cover_image = $filename;
            }

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
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->route('posts.show', $post->id)
                             ->with('error', 'Unauthorized Page');
        }

        if($post->cover_image) {
            Storage::delete('public/cover_images/' . $post->cover_image); 
        }

        $post->delete();
        return redirect($request->input('redirectTo'))
            ->with('success', 'Post deleted');
    }
        
    public function sortByTag(Tag $tag)
    {
        return view('posts.index', [
            'posts' => $tag->posts()->paginate(self::$paginate),
            'title' => 'Sort by Tag'.' '.$tag->name,
            'breadcrumbs' => [
                ['Home', '/'],
                ['Posts', '/posts'],
                ["Sort by Tag $tag->name", ""],
            ],
        ]);
    }
    
    public function orderByCreated() {
        return view('posts.index', [
            'posts' => Post::orderBy('created_at', 'desc')->paginate(self::$paginate),
            'title' => 'Order by Created Date',
            'breadcrumbs' => [
                ['Home', '/'],
                ["Order by Created Data", ""],
            ],
        ]);
    }

    public function orderByViews() {
        return view('posts.index', [
            'posts' => Post::orderBy('views', 'desc')->paginate(self::$paginate),
            'title' => 'Order by Views',
            'breadcrumbs' => [
                ['Home', '/'],
                ["Order by Views", ""],
            ],
        ]);
    }

    public function orderByLikes() {
        return view('posts.index', [
            'posts' => Post::orderBy('likes', 'desc')->paginate(self::$paginate),
            'title' => 'Order by Likes',
            'breadcrumbs' => [
                ['Home', '/'],
                ["Order by Likes", ""],
            ],
        ]);
    }

    public function orderByComments() {
        return view('posts.index', [
            'posts' => Post::orderByDesc('comments')->paginate(self::$paginate),
            'title' => 'Order by Comments',
            'breadcrumbs' => [
                ['Home', '/'],
                ["Order by Comments", ""],
            ],
        ]);
    }

    public function like(Request $request) {
        $post = Post::findOrFail($request->input('post_id'));
        
        $like = Like::where([
            'post_id' => $post->id,
            'user_id' => auth()->user()->id,
        ])->get();

        $dislike = Dislike::where([
            'post_id' => $post->id,
            'user_id' => auth()->user()->id,
        ])->get();

        if(!$like->count() && !$dislike->count()) {
            // add new like
            Like::create(['post_id' => $post->id, 'user_id' => auth()->user()->id]);
            $post->likes++;
        } elseif ($like->count() && !$dislike->count()) {
            // remove like
            $like->first()->delete();
            $post->likes--;
        } elseif (!$like->count() && $dislike->count()) {
            // add new like
            Like::create(['post_id' => $post->id, 'user_id' => auth()->user()->id]);
            $post->likes++;
            
            // remove dislike
            $dislike->first()->delete();
            $post->dislikes--;
        }

        $post->save();

        return redirect()->route('posts.show', $post->id);
    }
    
    public function dislike(Request $request) {
        $post = Post::findOrFail($request->input('post_id'));
        
        $like = Like::where([
            'post_id' => $post->id,
            'user_id' => auth()->user()->id,
        ])->get();

        $dislike = Dislike::where([
            'post_id' => $post->id,
            'user_id' => auth()->user()->id,
        ])->get();

        if(!$like->count() && !$dislike->count()) {
            // add new dislike
            Dislike::create(['post_id' => $post->id, 'user_id' => auth()->user()->id]);
            $post->dislikes++;
        } elseif (!$like->count() && $dislike->count()) {
            // remove dislike
            $dislike->first()->delete();
            $post->dislikes--;
        } elseif ($like->count() && !$dislike->count()) {
            // add new dislike
            Dislike::create(['post_id' => $post->id, 'user_id' => auth()->user()->id]);
            $post->dislikes++;
            
            // remove like
            $like->first()->delete();
            $post->likes--;
        }
        
        $post->save();

        return redirect()->route('posts.show', $post->id);
    }
}
