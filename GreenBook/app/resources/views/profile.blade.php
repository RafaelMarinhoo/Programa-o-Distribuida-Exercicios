@extends('layouts.app')

@section('content')
    
<div class="container">
    <div class="row justify-content-center">
        <div class="col md-4">
            <div class="card">
                <div class="card-header titulo"> Profile</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container emp-profile">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                        
                            <img src="{{ $user['foto'] }}" alt=""/>
                            @if($user['id'] == Auth::id())
                            <span data-toggle="modal" data-target="#changePhoto" class="file btn btn-lg btn-success col-md-4">
                                Change Photo
                                
                                
                             </span>
                            @else
                            <div>
                            &nbsp;
                            </div>
                            @endif
                            <div class="modal fade" id="changePhoto" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Photo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{ route('updatePhoto', $user) }}">
                               
                                @csrf

                                <input class="btn btn-sm btn-outline-success" data-container-upload = "inputfile" type="file" name="imagem"/>
                                <br>
                                <br>
                                <a href="{{ route('removePhoto') }}" class="removeFile btn btn-outline-danger">Remove Photo</a>
                                
                                
                               
                                
                                </div>
                                <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-outline-success">Save</button>
                            </form>
                        
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class='row justify-content-center'>
                           {{ $followers->count() }} followers
                        </div>
                        <div class='row justify-content-center'>
                          @if($user['id'] != Auth::id())

                          @if(!$followers->contains(Auth::id()))
                          <form method="post" action="{{ route('follow', $user) }}">
                          @csrf
                          <input type="hidden" name="id" value="{{ $user['id'] }}"/>
                          <button class='btn btn-outline-success'>Follow</button>
                          </form>

                          @else
                          <form method="post" action="{{ route('unfollow', $user) }}">
                          @csrf
                          <input type="hidden" name="id" value="{{ $user['id'] }}"/>
                          <button class='btn btn-outline-success'>Unfollow</button>
                          </form> 
                          @endif
                          @endif

                          

                        </div>
                    
                    </div>
                    
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                    {{ $user['name'] }}
                                    </h5>
                                    <h6>
                                       {{ $user['bio'] }}
                                    </h6>
                                    
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item  col-4">
                                    <a class="nav-link row" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item  col-4">
                                    <a class="nav-link row active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                </li>
                                <li class="nav-item  col-4">
                                    <a class="nav-link row" id="plantas-tab" data-toggle="tab" href="#plantas" role="tab" aria-controls="plantas" aria-selected="false">Plants</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if($user['id'] == Auth::id())
                    <div class="col-md-2 bg-white">
                        <button class="btn btn-outline-success" name="btnAddMore" data-toggle="modal" data-target="#ModalEdit" style="text-align: center"> Edit Profile</button>
                         
                        
                    </div>
                    <br>
                    <br>
                    @endif
                </div>

                <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="{{ route('profile.update', Auth::id()) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user['name'] }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bio" class="col-md-4 col-form-label text-md-right">{{ __('Bio') }}</label>

                            <div class="col-md-6">
                                <input id="bio" type="text" class="form-control" name="bio" value="{{ $user['bio'] }}" autocomplete="bio">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user['email'] }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                    

                    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                            <button type="sumbit" class="btn btn-outline-success">Save</button>
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>

                <div class="row">
                    <div class="col-md-4">
                        
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade info-tab" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>User Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $user['id'] }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $user['name'] }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $user['email'] }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Bio</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $user['bio'] }}</p>
                                            </div>
                                        </div>
                                        
                                        
                            </div>
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                       

                                       
                                       @if($user['id'] == Auth::id())
                                       <div class="row col">
                                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalPost">New Post</button>
                                        </div>
                                        <br>
                                        
                                        
                                        @endif
                                        
                                        
                                        <div class="modal fade" id="modalPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">New Post</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data" action="{{ route('profile.store') }}">
                                                
                                                @csrf
                                                <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Text') }}</label>

                                                <div class="col-md-6">
                                                    <input type="text" id="name" class="form-control"  name="text"></input>
                                                </div>
                                                <br>
                                                <br>
                                                <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>
                                                <div class="col-md-6">
                                                <input id="file" class="btn btn-sm btn-outline-success" data-container-upload = "inputfile" type="file" name="media"/>
                                                </div>
                                
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-outline-success">Save</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                            @if (!$user->posts()->count())
                                       <div class="row col-md-8 justify-content-center">
                                            <h3>No posts yet :(</h3>
                                       </div>
                                       @endif

                                       @foreach ( $posts as $post)
                                           @if (!empty($post['media']))
                                                    
                                                    <div class='card card-post col'>
                                                    <div class='card-header row'>
                                                        <div class='row col'>
                                                        <a class='row nav-link titulo' href="profile?id={{$user['id']}}" style='border: none; outline-style: none;'>
                                                            <img src="{{ $user['foto'] }}">
                                                            
                                                            &nbsp;{{$user['name']}}
                                                        </a>
                                                        </div>
                                                        @if(Auth::id() == $user['id'])
                                                        <div class="ml-3">
                                                            <form method="post" action="{{ route('removePost') }}">
                                                            @csrf
                                                            <input type="hidden" name='id' value="{{ $post['id'] }}"/>
                                                            <button type="submit" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>  </button>
                                                            </form>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class=" card-legend">{{ $post['text'] }}</div>
                                                    <div class='card-content row'>
                                                    <img src="{{ $post['media'] }}" style='width: 100%;'>
                                                    </div>
                                                    <div class='card-footer row justify-content-center'>
                                                        @if(App\Comment::where('post_id', $post['id'])->first())
                                                        <div class="row  justify-content-center">
                                                        
                                                        <a class="nav-link titulo" data-toggle="collapse" href="#commentCollapse{{ $post['id'] }}" role="button" aria-expanded="false" aria-controls="commentCollapse">
                                                        <span class="badge badge-success badge-pill">{{ App\Comment::where('post_id', $post['id'])->get()->count() }}</span> Comment(s) ▼
                                                        </a>
                                                        
                                                        </div>
                                                        @endif

                                                        
                                                        
                                                    
                                                        <div class="collapse row list-group" id="commentCollapse{{ $post['id'] }}" style="width:95%">
                                                        @if(App\Comment::where('post_id', $post['id'])->first())
                                                        @foreach(App\Comment::where('post_id', $post['id'])->get() as $comment)
                                                        <div class="list-group-item col">
                                                            <div class="row col-12">
                                                           <a href="profile?id={{App\User::where('id', $comment['user_id'])->get()->first()['id']}}" class="nav-link btn-sm">
                                                           <img class="comment-img" src="{{ App\User::whereId($comment['user_id'])->get()->first()['foto'] }}"/>
                                                            &nbsp;{{ App\User::whereId($comment['user_id'])->get()->first()['name'] }}
                                                           </a>
                                                           @if(Auth::id() == $comment['user_id'])
                                                        
                                                            <form method="post" class="col justify-content-end" action="{{ route('removeComment') }}">
                                                            @csrf
                                                            <input type="hidden" name='id' value="{{ $comment['id'] }}"/>
                                                            <button type="submit" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>  </button>
                                                            </form>
                                                       
                                                        @endif
                                                            </div>
                                                            
                                                           {{ $comment['text'] }}
                                                           </div>
                                                        @endforeach
                                                        @endif

                                                        </div>
                                                        
                                                        
                                                        <form method="post" class = "row col-12" action="{{ route('comment') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $post['id'] }}"/>
                                                        <input type="text" autocomplete="off" class="form-control" name="comment" placeholder="Type a comment"></input>
                                                        </form>
                                                        
                                                       
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>
                                                
                                                
                                                
                                                <br>
                                           
                                           
                                            @else
                                        
                                        <div class='card col card-post'>
                                        <div class='card-header row'>
                                            <div class='row col'>
                                            <a class='row nav-link titulo' href="profile?id={{$user['id']}}" style='border: none; outline-style: none;'>
                                                <img src=" {{ $user['foto'] }}">
                                                &nbsp;{{ $user['name']}}
                                            </a>
                                            </div>
                                            @if(Auth::id() == $user['id'])
                                            <div class="ml-3">
                                                <form method="post" action="{{ route('removePost') }}">
                                                    @csrf
                                                    <input type="hidden" name='id' value="{{ $post['id'] }}"/>
                                                    <button type="submit" class="close" data-dismiss="modal" aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>  </button>
                                                </form>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="">{{ $post['text'] }}</div>
                                        <div class='card-footer row justify-content-center'>
                                                        @if(App\Comment::where('post_id', $post['id'])->first())
                                                        <div class="row  justify-content-center">
                                                        
                                                        <a class="nav-link titulo" data-toggle="collapse" href="#commentCollapse{{ $post['id'] }}" role="button" aria-expanded="false" aria-controls="commentCollapse">
                                                        <span class="badge badge-success badge-pill">{{ App\Comment::where('post_id', $post['id'])->get()->count() }}</span> Comment(s) ▼
                                                        </a>
                                                        
                                                        </div>
                                                        @endif

                                                        
                                                        
                                                    
                                                        <div class="collapse row list-group" id="commentCollapse{{ $post['id'] }}" style="width:95%">
                                                        @if(App\Comment::where('post_id', $post['id'])->first())
                                                        @foreach(App\Comment::where('post_id', $post['id'])->get() as $comment)
                                                        <div class="list-group-item col">
                                                            <div class="row col-12">
                                                           <a href="profile?id={{App\User::where('id', $comment['user_id'])->get()->first()['id']}}" class="nav-link btn-sm">
                                                           <img class="comment-img" src="{{ App\User::whereId($comment['user_id'])->get()->first()['foto'] }}"/>
                                                            &nbsp;{{ App\User::whereId($comment['user_id'])->get()->first()['name'] }}
                                                           </a>
                                                           @if(Auth::id() == $comment['user_id'])
                                                        
                                                            <form method="post" class="col justify-content-end" action="{{ route('removeComment') }}">
                                                            @csrf
                                                            <input type="hidden" name='id' value="{{ $comment['id'] }}"/>
                                                            <button type="submit" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>  </button>
                                                            </form>
                                                       
                                                        @endif
                                                            </div>
                                                            
                                                           {{ $comment['text'] }}
                                                           </div>
                                                        @endforeach
                                                        @endif

                                                        </div>
                                                        
                                                        
                                                        <form method="post" class = "row col-12" action="{{ route('comment') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $post['id'] }}"/>
                                                        <input type="text" autocomplete="off" class="form-control" name="comment" placeholder="Type a comment"></input>
                                                        </form>
                                                        
                                                       
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>
                                                
                                                
                                                
                                                <br>
                                            @endif
                               
                                       
                                       @endforeach

                                       
                            </div>
                            <div class="tab-pane fade" id="plantas" role="tabpanel" aria-labelledby="plantas-tab">
                                @if($user['id'] == Auth::id())
                                <div class="row col-md-4">
                                
                                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalPlant">New Plant</button>
                                
                                </div>
                                <br>
                                @endif

                                <div class="modal fade" id="modalPlant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New Plant</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <form method="post" enctype="multipart/form-data" action="{{ route('addPlant') }}">
                                        
                                        @csrf
                                        <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input class="form-control" type="text" maxlength="16" id="name"  name="name"></input>
                                        </div>
                                        <br>
                                        <br>
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>
                                        <div class="col-md-6">
                                        <input class="btn btn-sm btn-outline-success" data-container-upload = "inputfile" type="file" name="media"/>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                    
                                    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-outline-success">Save</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                            
                            </div>
                            @if (!$user->plants()->count())
                                       <div class="row col-md-8 justify-content-center">
                                            <h3>No plants yet :(</h3>
                                       </div>
                                       @endif
                                       <div class="row col-md-12">
                                       @foreach ( $plants as $plant)
                                                    
                                                    <div class='card card-post col-md-5'>
                                                    <div class='card-header row'>
                                                    <div class="row ml-auto">
                                                    <form method="get" action="{{ route('diary') }}">
                                                    
                                                    
                                                    <input type="hidden" value="{{ $plant['id'] }}" name="id"/>
                                                    <button type="submit" class='nav-link titulo row' style='border: none; outline-style: none; background-color: inherit;'>{{$plant['name']}}</button>
                                                    </form>
                                                    </div>
                                                    
                                                    <div class=" ml-auto mb-auto">
                                                    @if(Auth::id() == $user['id'])
                                                            <form method="post" action="{{ route('removePlant') }}">
                                                            @csrf 
                                                            <input type="hidden" value="{{ $plant['id'] }}" name="id"/>
                                                            <button type="submit" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>  </button>
                                                            </form>
                                                    @endif
                                                    </div>
                                                    
                                                    </div>
                                                    
                                                    
                                                    <div class='row card-content justify-content-center'>
                                                    <img src="{{ $plant['media'] }}" style='width: 100%;'>
                                                    </div>
                                                    
                                                </div>
                                                &nbsp;
                                                
                                           
                                           
                                           
                                            
                               
                                       
                                       @endforeach
                                        </div>
                        </div>
                    </div>
                </div>
                    
        </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection