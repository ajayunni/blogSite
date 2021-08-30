<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    public function post()
    {
        $this->belongsTo('App\Post');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
