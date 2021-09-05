@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
                

                
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row justify-content-center paper">
                    <h4 class="titulo col offset-5 plant-name justify-content-center">{{ $plant['name'] }}</h4>
                    <form method="post" action="{{ route('diaryUpdate') }}">
                    @csrf 
                        <div class="paper-content">
                        
                            <textarea class="diary" name="diary" autofocus>{{ $plant['diary'] }}</textarea>
                            <div class="row col justify-content-center">
                                
                                
                                    <input type="hidden" name="id" value="{{ $plant['id'] }}"/>
                                    <button type="submit" class="bt-diary nav-link btn">Save</button>
                                </form>
                                    &nbsp; &nbsp;
                                   <a href="{{ route('profile') }}" class="bt-diary nav-link btn">Back</a>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                
            
        </div>
    </div>
</div>
@endsection
