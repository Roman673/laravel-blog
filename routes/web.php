<?php

use App\Post;
use Illuminate\Auth\Middleware\Authenticate;

Route::get('/', 'IndexController')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/posts', 'PostController');

Route::resource('/comments', 'CommentController', ['except' => [
    'index', 'Show', 'create', 'store',
]]);

Route::post('/posts/{post}/comment-add', 'CommentController@store')
    ->name('comments.store');
