$(document).ready(function(){
    $('#PasswordMatchMessage').html('');
    $('#UserPassword').keyup(checkPasswordsMatch);
    $('#UserPassword').keydown(checkPasswordsMatch);
    $('#UserRepeatPassword').keyup(checkPasswordsMatch);
    $('#UserRepeatPassword').keydown(checkPasswordsMatch);
});

function checkPasswordsMatch(){
    if($('#UserPassword').val() != $('#UserRepeatPassword').val()){
        $('#PasswordMatchMessage').text('Your passwords don\'t match');
        $('#RegisterButton').attr('disabled', true);
    }else{
        $('#PasswordMatchMessage').text('');
        $('#RegisterButton').removeAttr('disabled');
    }
}