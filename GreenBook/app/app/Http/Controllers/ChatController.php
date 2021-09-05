<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Message;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
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
    public function index(Request $request)
    {
        $id = $request->id;
        if($id){
            $validate = User::where('id', $id)->first();
            if($validate){
                $user = User::where('id', Auth::id())->first();
                $receiver = User::whereId($request->id)->first();
                return view('chat', ['user' => $user, 'receiver' => $receiver]);
            }else return redirect(route('messages'));
        
        }else{
            return redirect(route('messages'));
        }
    }

    public function insertMessage(Request $request){
        if(isset($request->env) && $request->env == "envMsg"){
           $text = $request->mensagem;
            
            if(empty($text)){
                
            }else{

                date_default_timezone_set('America/Recife');
                 $message = new Message;
                 $message->sender_id = Auth::id();
                 $message->receiver_id = $request->receiver;
                 $message->text = $text;
                 $message->save();
                
            }
        }
    }

    public function list(Request $request){

          $user = Auth::user();
          $receiver = User::whereId($request->receiver)->first();
    

         $messages = DB::table('messages')->where([
                ['sender_id', $user->id], ['receiver_id', $receiver->id]
                ])->orWhere([
                    ['receiver_id', $user->id], ['sender_id', $receiver->id]
                    ])->get();
         

          foreach ($messages as $msg) {
                  if($msg->sender_id == $user->id){
                  echo "<div id='chat-right' class = 'row'><small class='row col justify-content-end ml-auto titulo'>You</small><label class='msg'>".$msg->text."</label><small class='row col justify-content-end ml-auto'>".date('d-m-y \a\t g:i a', strtotime($msg->created_at))."</small></div>";
                  }else{
        
                  echo "<div id='chat-left' class = 'row'><small class='row col titulo'>".$receiver->name."</small><label class='msg'>".$msg->text."</label><small class='row col'>".date('d-m-y \a\t g:i a', strtotime($msg->created_at))."</small></div>";
                  }
        
             }

        
        
        
        }
    
}