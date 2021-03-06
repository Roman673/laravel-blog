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

Route::resource('/tags', 'TagController');

Route::get('/posts/tag/{tag}', 'PostController@sortByTag')
    ->name('posts.sortByTag');

Route::get('/posts/order/created', 'PostController@orderByCreated')
    ->name('posts.orderByCreated');

Route::get('/posts/order/views', 'PostController@orderByViews')
    ->name('posts.orderByViews');

Route::get('/posts/order/likes', 'PostController@orderByLikes')
    ->name('posts.orderByLikes');

Route::get('/posts/order/comments', 'PostController@orderByComments')
    ->name('posts.orderByComments');

Route::post('/posts/like', 'PostController@like')->name('posts.like');

Route::post('/posts/dislike', 'PostController@dislike')->name('posts.dislike');
