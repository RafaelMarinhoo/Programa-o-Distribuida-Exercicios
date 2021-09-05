var timerI = null;
    var timerR = false;
    

    function para(){
        if(timerR){
        clearTimeout(timerI);
        timerR = false;
        }

    }

    function comeca(){
        para();
        lista();
    }

    function lista(){
        $.ajaxSetup({
            beforeSend: function(xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            },
        });

        $.ajax({
            url:"/GreenBook/app/public/list",
            success: function(textStatus){
                $("#lista").html(textStatus);
            },
            error: function() {
                
        }
        })
        timerI = setTimeout("lista()", 1000);
        timerR = true;
    }
    

    $(document).ready(function(){
        comeca();
    });