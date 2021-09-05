@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header titulo">Search</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if($users->count() > 0)
                    @foreach($users as $user)
                    
                    
                   
                    <a class="nav-link" href="profile?id={{ $user->id }}">
                    <div class="card-header card-post">
                    <div class="row col">
                    <img src="{{ $user->foto }}">
                    <button class="titulo" style="color: inherit; background-color: inherit; border: none; outline-style: none;"> {{ $user->name }}</button>
                    <small>{{ $user->followers()->count() }} followers</small>
                    </div>
                
                    </div>
                    </a>
                    
                    @endforeach
                    @else
                    <div class="row justify-content-center">
                    <h2>No results for "{{ $query }}".</h2>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
