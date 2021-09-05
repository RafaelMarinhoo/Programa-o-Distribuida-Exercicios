<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;
        if($id){
            

            $user = User::where('id', $id)->first();
            

            if($user){
            $posts = $user->posts()->orderBy('id', 'desc')->get();
            $plants = $user->plants()->orderBy('id', 'desc')->get();
            $followers = $user->followers()->orderBy('follower', 'desc')->get();
            $followeds = $user->followeds()->orderBy('follower', 'desc')->get();
            return view('profile', ['user' => $user, 'posts' => $posts, 'plants' => $plants, 'followers' => $followers, 'followeds' => $followeds]);
            }else return view('unknownProfile');
        }else{

        $user = User::where('id', Auth::id())->first();
        $posts = Auth::user()->posts()->orderBy('id', 'desc')->get();
        $plants = $user->plants()->orderBy('id', 'desc')->get();
        $followers = $user->followers()->orderBy('follower', 'desc')->get();
        $followeds = $user->followeds()->orderBy('follower', 'desc')->get();
        return view('profile', ['user' => $user, 'posts' => $posts, 'plants' => $plants, 'followers' => $followers, 'followeds' => $followeds]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->user_id = Auth::id();

        if(!empty($request->text)){
        $post->text = $request->text;
        }
        
        if(!empty($_FILES["media"]["tmp_name"])){
            $nome_temporario=$_FILES["media"]["tmp_name"];
            $nome_real=$_FILES["media"]["name"];
            copy($nome_temporario,"img/posts/$nome_real");
            $caminho = "img/posts/$nome_real";

            $post->media = $caminho;
        }    
            if(!empty($request->text) or !empty($_FILES["media"]["tmp_name"])){
            $post->save();
            Auth::user()->posts()->save($post);
            }
    
            return redirect(route('profile'));
    }

    public function removePost(Request $request)
    {

           $post = Post::find($request->id);
           $post->delete();
    
           return redirect()->back();
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'bio' => '',
        
            
        ]);

    
        Auth::user()->update($validatedData);

        if(!empty($request->password)){
            $arr = array(
                'password' => Hash::make($request->password),
            );
            Auth::user()->update($arr);
            }
        
        
        return redirect(route('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request, User $user)
    {
        $nome_temporario=$_FILES["imagem"]["tmp_name"];
        $nome_real=$_FILES["imagem"]["name"];
        copy($nome_temporario,"img/$nome_real");
        $caminho = "img/$nome_real";
        $arr = array(
         "foto" => $caminho,
        );
        Auth::user()->update($arr);

        return redirect(route('profile'));
    }

    public function removePhoto()
    {
        
        $caminho = "img/semfoto.svg";
        $arr = array(
         "foto" => $caminho,
        );
        Auth::user()->update($arr);

        return redirect(route('profile'));
    }

    public function deleteUser(Request $request)
    {
        
        $user = Auth::user();
        if(password_verify($request->password, $user->password)){
        $user->delete();
        return redirect(url('/'));
        }else{
                echo"<script>
                    alert('Incorrect Password');
                history.go(-1);
                </script>";
                exit;
        }
          

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
    }

    
    public function follow(Request $request)
    {
        $userId = Auth::id();
        $id = $request->id;
        $user = User::where('id', $id)->first();
        $user->followers()->attach($userId);

        return redirect(url('/profile?id='.$id));


    }

    public function unfollow(Request $request)
    {
        $userId = Auth::id();
        $id = $request->id;
        $user = User::where('id', $id)->first();
        $user->followers()->detach($userId);

        return redirect(url('/profile?id='.$id));


    }

    public function addPlant(Request $request)
    {
        $plant = new Plant;
        $plant->user_id = Auth::id();
        $plant->name = $request->input('name');

        if(!empty($_FILES["media"]["tmp_name"])){
            $nome_temporario=$_FILES["media"]["tmp_name"];
            $nome_real=$_FILES["media"]["name"];
            copy($nome_temporario,"img/plants/$nome_real");
            $caminho = "img/plants/$nome_real";
    
            $plant->media = $caminho;
      
        }
        $plant->save();
        return redirect()->back();

    }

    public function removePlant(Request $request)
    {

           $plant = Plant::find($request->id);
           $plant->delete();
    
            return redirect(route('profile'));
    }

    
}
