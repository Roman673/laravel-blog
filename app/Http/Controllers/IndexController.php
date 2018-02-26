<?php

namespace App\Http\Controllers;

use App\Post;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('index', [
            'posts' => Post::all(),
            'title' => 'Index Page',
        ]);
    }
}
