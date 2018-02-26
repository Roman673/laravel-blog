<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liked_posts = Like::where('user_id', auth()->user()->id)
                            ->whereRaw('is_liked = 1 or is_disliked = 1')
                            ->get();
                            
        return view('dashboard', [
            'liked_posts' => $liked_posts,
            'title' => 'Home Page',
        ]);
    }
}
