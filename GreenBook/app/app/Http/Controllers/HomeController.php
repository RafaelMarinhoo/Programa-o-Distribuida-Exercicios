<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        
        $user = Auth::user();
        $ids = [$user->id];
        $arr = $user->followeds()->get();
        foreach($arr as $value){
            array_push($ids, $value->id);
        }
        
        $posts = Post::whereIn('user_id', $ids)->latest()->get();
        
        
        
        return view('home', ['user' => $user, 'posts' => $posts]);
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->user_id = Auth::id();
        $post->text = $request->input('text');

        if(!empty($_FILES["media"]["tmp_name"])){
            $nome_temporario=$_FILES["media"]["tmp_name"];
            $nome_real=$_FILES["media"]["name"];
            copy($nome_temporario,"img/posts/$nome_real");
            $caminho = "img/posts/$nome_real";

            $post->media = $caminho;
        }    
            
            $post->save();
            Auth::user()->posts()->save($post);

        return redirect(route('home'));

    }

    public function comment(Request $request){
        
        $comment = new Comment;
        $comment->post_id = $request->id;
        $comment->user_id = Auth::id();
        $comment->text = $request->comment;

        $comment->save();

        return redirect()->back();

    }

    public function removeComment(Request $request){
        
        $comment = Comment::find($request->id);

        $comment->delete();

        return redirect()->back();

    }
}
