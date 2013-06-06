$(document).ready(function(){
    $('#UsernameValidMessage').html('');
    $('#RegisterButton').attr('disabled', true);
    $('#UserUsername').keyup(checkUsernameIsValid);
    $('#UserUsername').keydown(checkUsernameIsValid);
});

function checkUsernameIsValid(){
    if($('#UserUsername').val() === ''){
        $('#UsernameValidMessage').html('Your username can\'t be blank');
        return;
    }
    $('#UsernameValidMessage').html('Checking new username...');
    var request = 
    $.ajax("http://www.dev.thinkshare.it/cakephp/users/checkExistence",
    {
        type: "POST",
        data: 
            {
                username : $('#UserUsername').val()
            },
        dataType: "JSON"
    });
    
    request.done(function(data){
        if(data.exists){
            $('#UsernameValidMessage').html('This user already exists, invalid username!');
            $('#RegisterButton').attr('disabled', true);
        }
        else
        {
            $('#UsernameValidMessage').html('Valid username');
            $('#RegisterButton').removeAttr('disabled');
        }
    });
}