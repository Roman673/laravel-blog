<?php

use App\Post;
use Illuminate\Auth\Middleware\Authenticate;

Route::get('/', 'IndexController')->name('index');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('/posts', 'PostController');

Route::resource('/comments', 'CommentController', ['except' => [
    'index', 'Show', 'create',
]]);

