<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        $this->belongsTo('App\Post');
    }

    public function replies()
    {
        return $this->hasMany('App\Comment', 'parent_id');
    }

    public function deleteRelatedData()
    {
        $this->replies->each->deleteRelatedData();
        $this->delete();
    }
}
