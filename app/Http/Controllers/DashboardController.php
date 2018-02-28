<?php

namespace App\Http\Controllers;

use App\Dislike;
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
    public function index() {
        return view('dashboard', [
            // Get all posts with an authorized user's likes
            'liked_posts' => Like::where('user_id', auth()->user()->id)->get(),
            // Get all posts wiht an authorized user's dislikes
            'disliked_posts' => Dislike::where('user_id', auth()->user()->id)->get(),
            'title' => 'Home Page',
            'breadcrumbs' => [
                ['Dashboard', ''],
            ],
        ]);
    }
}
