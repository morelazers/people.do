$(document).ready(function(){
    $('#UsernameValidMessage').html('');
    $('#RegisterButton').attr('disabled', true);
    
    var input = $('#RegisterUsername');
    input.on('keydown', function() {
        var key = event.keyCode || event.charCode;
    
        if( key == 8 || key == 46 ){
           $('#UsernameValidMessage').html('');
        } else {
            checkUsernameIsValid();
        }
    });
    input.on('keyup', function() {
        var key = event.keyCode || event.charCode;
    
        if( key == 8 || key == 46 ){
           $('#UsernameValidMessage').html('');
        } else {
            checkUsernameIsValid();
        }
    });
    
});

function checkUsernameIsValid(){
    if($('#RegisterUsername').val() === ''){
        $('#UsernameValidMessage').html('');
        return;
    }
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