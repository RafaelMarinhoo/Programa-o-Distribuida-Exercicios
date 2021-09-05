@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col md-4">
            <div class="card">
                <div class="card-header"> Profile</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row justify-content-center">
                    <h2>Unknown Profile :( &#127793	 </h2>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection