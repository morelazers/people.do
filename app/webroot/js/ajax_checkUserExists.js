$(document).ready(function(){
    $('#UsernameValidMessage').html('');
    $('#MessageRecipient').keyup(checkUsernameIsValid);
    $('#MessageRecipient').keydown(checkUsernameIsValid);
});

function checkUsernameIsValid(){
        $('#UsernameValidMessage').html("Checking username...");
        $('#SendButton').attr('disabled', true);
        var request = 
        $.ajax(window.location.origin + "/users/checkExistence",
        {
            type: "POST",
            data: 
                {
                    username : $('#MessageRecipient').val()
                },
            dataType: "JSON"
        });
        
        request.done(function(user){
            if(user.exists){
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
