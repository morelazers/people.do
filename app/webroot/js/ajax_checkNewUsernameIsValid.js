$(document).ready(function(){
    $('#UsernameValidMessage').html('');
    $('#RegisterButton').attr('disabled', true);
    
    var input = $('#RegisterUsername');
    input.on('keydown', function(event) {
        var key = event.keyCode || event.charCode;
        
        if(key == 32){
          event.preventDefault(); 
          var str = $(this).val();
          str = str.replace(/\s/g,'');
          $(this).val(str);
        }
        
        if($(this).val() !== $(this).val().replace(/[^a-z0-9\s]/gi, '')){
          $('#UsernameValidMessage').html('No special characters please.');
          $(this).val($(this).val().replace(/[^a-z0-9\s]/gi, ''));
        }
    
        if( key == 8 || key == 46){
           $('#UsernameValidMessage').html('');
        } else {
            checkUsernameIsValid();
        }
        
    }).blur(function() {
        $(this).val(function(i,oldVal){ return oldVal.replace(/[^a-z0-9\s]/gi, ''); });     
    });
    
    input.on('keyup', function() {
        var key = event.keyCode || event.charCode;
        
        /*var str = $(this).val();
        str = str.replace(/\s/g,'');
        $(this).val(str);*/
        
        if($(this).val() !== $(this).val().replace(/[^a-z0-9\s]/gi, '')){
          $('#UsernameValidMessage').html('No special characters please.');
          $(this).val($(this).val().replace(/[^a-z0-9\s]/gi, ''));
        }
    
        if( key == 8 || key == 46 ){
           $('#UsernameValidMessage').html('');
        } else {
            checkUsernameIsValid();
        }
        
    }).blur(function() {
        $(this).val(function(i,oldVal){ return oldVal.replace(/[^a-z0-9\s]/gi, ''); });      
    });
    
});

function checkUsernameIsValid(){
    console.log($('#RegisterUsername').val());
    if($('#RegisterUsername').val() == ''){
        $('#UsernameValidMessage').html('');
        return;
    }
    console.log( $('#RegisterUsername').val());
    $('#UsernameValidMessage').html('Checking new username...');
    var request = 
    $.ajax(window.location.origin + "/users/checkExistence",
    {
      type: "POST",
      data: 
        {
          username : $('#RegisterUsername').val()
        },
      dataType: "JSON"
    });
    
    request.done(function(data){
      if(data.exists){
        $('#UsernameValidMessage').html('This user already exists, we can\'t have two!');
        $('#RegisterButton').attr('disabled', true);
      } else {
        $('#UsernameValidMessage').html($("#RegisterUsername").val()+' is free!');
        $('#RegisterButton').removeAttr('disabled');
      }
    });
}