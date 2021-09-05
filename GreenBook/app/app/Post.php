<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'user_id', 'text', 'media',
    ];

    public function usuario(){
        return $this->belongsTo('User');
    }

    public function comments(){
        return $this->hasMany('Comment');
    }
}
