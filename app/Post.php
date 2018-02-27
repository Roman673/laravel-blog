<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body'];
    
    public function comment_set()
    {
        return $this->hasMany('App\Comment');
    }

    public function like_set()
    {
        return $this->hasMany('App\Like');
    }

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
