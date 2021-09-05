<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\User;

class Plant extends Model
{
    protected $table = 'plants';
    protected $fillable = [
        'user_id', 'name', 'media', 'diary',
    ];

    public function usuario(){
        return $this->belongsTo('User');
    }
}