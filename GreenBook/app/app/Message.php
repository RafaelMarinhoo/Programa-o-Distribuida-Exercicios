<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'sender_id', 'receiver_id', 'text',
    ];

    public function sender(){
        return $this->belongsTo('User', 'sender_id');
    }

    public function receiver(){
        return $this->belongsTo('User', 'receiver_id');
    }



}