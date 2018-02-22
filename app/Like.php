<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['post_id', 'user_id', 'is_liked', 'is_disliked'];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
