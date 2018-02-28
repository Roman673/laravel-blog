<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    public function post() {
        return $this->belongsTo('App\Post');
    }
}
