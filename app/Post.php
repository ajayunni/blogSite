<?php

namespace App;

use App\User;
use \Cache;
use Facades\App\Repository\posts;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('created_at','DESC');
    }
    public function likes(){
        return $this->hasMany('App\like')->orderBy('created_at','ASC');
    }
    public function howManyLikes(){
        return $this->hasMany('App\like')->count();
    }
    public function howManyComments(){
        return $this->hasMany('App\Comment')->count();
    }
    public function likedByUser()
    {
        return $this->likes()->where('user_id', Auth::user()->id);
    }
    //For clearing cache and see changes right away!
    protected static function boot()
    {
        parent::boot();
        static::saving(function() {
            Cache::forget(posts::getCacheKey("all.created_at"));
        });
        static::deleting(function() {
            Cache::forget(posts::getCacheKey("all.created_at"));
        });
        static::updating(function() {
            Cache::forget(posts::getCacheKey("all.created_at"));
        });
    }
}
