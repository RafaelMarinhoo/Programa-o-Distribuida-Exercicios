<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class MessagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        $arr = [];
        $followeds = $user->followeds()->get();
        $sent = $user->sentMessages()->get();
        $received = $user->receivedMessages()->get();

        foreach($followeds as $value){
            array_push($arr, User::whereId($value->id)->first());
        }
        
        foreach($sent as $value){
            array_push($arr, User::whereId($value->receiver_id)->first());
        }
        
        foreach($received as $value){
            array_push($arr, User::whereId($value->sender_id)->first());
        }
        
        $arr = array_unique($arr);
        
        
        return view('messages', ['user' => $user, 'messages' => $arr]);
    }
}