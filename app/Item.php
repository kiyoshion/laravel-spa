<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Auth;
// use Auth;

class Item extends Model
{
    protected $perPage = 15;

    protected $appends = [
        'likes_count', 'liked_by_user'
    ];

    protected $visible = [
        'id', 'user', 'body', 'comments', 'likes_count', 'liked_by_user', 
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    public function getLikedByUserAttribute()
    {
        if (\Auth::guest()) {
            return false;
        }

        return $this->likes->contains(function ($user) {
            return $user->id === \Auth::user()->id;
        });
    }
}
