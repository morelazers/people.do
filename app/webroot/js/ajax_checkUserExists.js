$(document).ready(function(){
    $('#UsernameValidMessage').html('');
    $('#MessageRecipient').keyup(checkUsernameIsValid);
    $('#MessageRecipient').keydown(checkUsernameIsValid);
});

function checkUsernameIsValid(){
        $('#UsernameValidMessage').html("Checking username...");
        $('#SendButton').attr('disabled', true);
        var request = 
        $.ajax("http://www.dev.thinkshare.it/cakephp/users/checkExistence",
        {
            type: "POST",
            data: 
                {
                    username : $('#MessageRecipient').val()
                },
            dataType: "JSON"
        });
        
        request.done(function(data){
            if(data.exists){
                $('#UsernameValidMessage').html('This user exists!');
                $('#SendButton').removeAttr('disabled');
            }
            else
            {
                $('#UsernameValidMessage').html('This user doesn\'t exist!');
                $('#SendButton').attr('disabled', true);
            }
        });
}
