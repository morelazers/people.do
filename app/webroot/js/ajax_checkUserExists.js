$(document).ready(function(){
    $('#UsernameValidMessage').html('');
    $('#MessageRecipient').keyup(checkRecipientIsValid);
    $('#MessageRecipient').keydown(checkRecipientIsValid);
});

function checkRecipientIsValid(){
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
