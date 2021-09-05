<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'bio', 'foto', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function plants(){
        return $this->hasMany('App\Plant');
    }

    public function followeds(){
        return $this->belongsToMany('App\User', 'user_user', 'follower', 'followed');
    }

    public function followers(){
        return $this->belongsToMany('App\User', 'user_user', 'followed', 'follower');
    }

    public function sentMessages(){
        return $this->hasMany('App\Message', 'sender_id');
    }

    public function receivedMessages(){
        return $this->hasMany('App\Message', 'receiver_id');
    }

}
