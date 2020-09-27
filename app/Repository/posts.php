<?php
namespace App\Repository;
Class posts{
    CONST CACHE_KEY = 'USERS';
    public function all($orderBy){
        $key = "all.{$orderBy}";
        $cacheKey = $this->getCacheKey($key);
        return cache()->remember($cacheKey,\Carbon\Carbon::now()->addHour(1),function () use($orderBy){
           return \App\Post::orderBy($orderBy,'desc')->get();
        });
    }
    public function getCacheKey($key){
        $key = strtoupper($key);
        return self::CACHE_KEY .".$key";
    }
}
