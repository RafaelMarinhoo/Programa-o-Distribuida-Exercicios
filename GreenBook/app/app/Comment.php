<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'post_id', 'user_id', 'text',
    ];

    public function user(){
        return $this->belongsTo('User', 'user_id');
    }

    public function post(){
        return $this->belongsTo('Post', 'post_id');
    }



}