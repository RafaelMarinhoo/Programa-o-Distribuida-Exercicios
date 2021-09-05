@extends('layouts.app')

@section('content')
@csrf
 <script>
    
    setInterval("lista()", 1000);
    
    function lista(){
        $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
        $.ajax({
            
            url:"{{ url('/list') }}",
            data: "receiver={{ $receiver['id'] }}",
            cache: false,
            success: function(textStatus){
                
                $("#lista").html(textStatus);
                
                
            },
            error: function() {     
        }
        })
        
    }


    
    $(document).ready(function(){   
        
        lista();
        

        $("form[ajax=true]").submit(function(e) {
            $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
        
        e.preventDefault();
        
        var form_data = $(this).serialize();
        var form_url = $(this).attr("action");
        var form_method = $(this).attr("method").toUpperCase();
        
        $.ajax({
            url: form_url, 
            type: form_method,      
            data: form_data,     
            cache: false,
            success: function(){
               lista();
               
            }
                     
        });    
        $("#lista").animate({scrollTop: $('#lista').prop("scrollHeight")}, 1000);
        $('form[ajax=true]').trigger("reset");
    });   
    setTimeout("$('#lista').animate({scrollTop: $('#lista').prop('scrollHeight')}, 500)", 500);
    });
    

    
</script>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header titulo">
                    <div class="row col justify-content-center">
                    <a class="nav-link"href="profile?id={{ $receiver['id'] }}">
                        <img src="{{ $receiver['foto'] }}">  {{ $receiver['name'] }} 
                    </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    

                    <div id='lista' class="col "></div>
                        <form id="form-chat" action="{{ url('/insertMessage') }}" method="GET" enctype="multipart/form-data" ajax="true">
                        @method('GET')
                        
                            <div class="col">
                                <div class="input-group">
                                    <input autocomplete='off' type="text" name="mensagem" id="mensagem" placeholder="Type a message" class="form-control"/>&nbsp;&nbsp;
                                    <span class="input-group-btn">
                                        <input type="submit" value="&rang;&rang;" class="btn btn-outline-success">
                                        <input type="hidden" name="env" value="envMsg">
                                        <input type="hidden" name="receiver" value="{{ $receiver['id'] }}">
                                    </span>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
