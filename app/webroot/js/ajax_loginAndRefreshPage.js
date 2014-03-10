$(document).ready(function(){
    
    $("#UserLoginForm").submit(function(event){
        event.preventDefault();
        loginAndRefresh();
    });
    $("#UserAddForm").submit(function(event){
        event.preventDefault();
        registerAndRefresh();
    });
    
   $('#RegisterButton').attr('disabled', true);
   
   $("#FacebookModalButton").click(function(){
        fbLoginAndRefresh(); 
   });
   $("#GPlusModalButton").click(function(){
        gPlusLoginAndRefresh(); 
   });
});

function loginAndRefresh(){
    $("#ModalLoginMessage").text("Logging in...");
    var username = $('#UserUsername').val();
    var password = $('#LoginPassword').val();
    
    if(!username || !password){
        $("#ModalLoginMessage").text("That's not quite right, try again?");
        return;
    }
    
    var request = 
    $.ajax(window.location.origin + "/users/ajax_login",
    {
        type: "POST",
        data: 
            {
                username : username,
                password : password
            },
        dataType: "JSON"
    });
    
    request.done(function(data){
        if(data.valid){
            $("#ModalLoginMessage").text("Logged you in, hang tight!");
            window.userIsLoggedIn = true;
            if(document.URL.indexOf("/share") >= 0){ 
                $("#IdeaAddForm").submit();
            } else if(window.commentSubmit){
                getUserId();
                var element = $('<input type="hidden" name="data[Comment][UserId]" value="'+window.userId+'" id="CommentUserId">');
                $("#CommentForm").prepend(element);
                $("#CommentForm").submit();
            } else if(window.messageSend) {
                $("#MessageSendForm").submit();    
            } else {
                window.location.reload();
            }
        } else {
            $("#ModalLoginMessage").text("That's not quite right, try again?");
        }
    });
}

function registerAndRefresh() {
    $("#ModalRegisterMessage").text("Registering...");
    var username = $('#RegisterUsername').val();
    var password = $('#UserPassword').val();
    var email = $('#UserEmail').val();
    
    if(!username){
        $("#ModalRegisterMessage").text("We can't let you sign up without a username!");
        return;
    }
    
    username = username.replace(/[^a-z0-9\s]/gi, '');
    
    var request = 
    $.ajax(window.location.origin + "/users/ajax_register",
    {
        type: "POST",
        data: 
            {
                username : username,
                password : password,
                email :email
            },
        dataType: "JSON"
    });
    
    request.done(function(data){
        if(data.valid){
            $("#ModalRegisterMessage").text("Registered you, here we go!");
            $("#LoginModal").modal('toggle');
            window.userIsLoggedIn = true;
            if(document.URL.indexOf("/share") >= 0){ 
                $("#IdeaAddForm").submit();
            } else if(window.commentSubmit){
                getUserId();
                var element = $('<input type="hidden" name="data[Comment][UserId]" value="'+window.userId+'" id="CommentUserId">');
                $("#CommentForm").prepend(element);
                $("#CommentForm").submit();
            } else if(window.messageSend) {
                $("#MessageSendForm").submit();    
            } else {
                window.location.reload();
            }
        } else {
            $("#ModalRegisterMessage").text("We couldn't register you, something must've broke; try again in a minute or two");
        }
    });
}

function fbLoginAndRefresh(){
    $("#OpAuthMessage").text("One sec...");
    
    var sessionSetRequest =
    $.ajax(window.location.origin + '/users/ajaxOpauth',
    {
        type: "POST"
    });
    
    sessionSetRequest.done(function(){
        var facebookAuthWindow = window.open(window.location.origin + '/auth/facebook');
        var checkClosed = function(){
            if(facebookAuthWindow.closed){
                fbAuthorised();
            } else {
                window.setTimeout(checkClosed, 1000);
            }
        };
        
        var fbAuthorised = function() {
            $("#OpAuthMessage").text("Logged you in!");
            $("#LoginModal").modal('toggle');
            window.userIsLoggedIn = true;
            if(document.URL.indexOf("/share") >= 0){ 
                $("#IdeaAddForm").submit();
            } else if(window.commentSubmit){
                getUserId();
                var element = $('<input type="hidden" name="data[Comment][UserId]" value="'+window.userId+'" id="CommentUserId">');
                $("#CommentForm").prepend(element);
                $("#CommentForm").submit();
            } else if(window.messageSend) {
                $("#MessageSendForm").submit();    
            } else {
                window.location.reload();
            }
        };
        
        if(checkClosed()) {
            fbAuthorised();
        }
        
    });
}

function gPlusLoginAndRefresh(){
    $("#OpAuthMessage").text("One sec...");
    
    var sessionSetRequest =
    $.ajax(window.location.origin + '/users/ajaxOpauth',
    {
        type: "POST"
    });
    
        sessionSetRequest.done(function(){
        var googleAuthWindow = window.open(window.location.origin + '/auth/google');
        
        var checkClosed = function(){
            if(googleAuthWindow.closed){
                googleAuthorised();
            } else {
                window.setTimeout(checkClosed, 1000);
            }
        };
        
        var googleAuthorised = function() {
            $("#OpAuthMessage").text("Logged you in!");
            $("#LoginModal").modal('toggle');
            window.userIsLoggedIn = true;
            if(document.URL.indexOf("/share") >= 0){ 
                $("#IdeaAddForm").submit();
            } else if(window.commentSubmit){
                getUserId();
                var element = $('<input type="hidden" name="data[Comment][UserId]" value="'+window.userId+'" id="CommentUserId">');
                $("#CommentForm").prepend(element);
                $("#CommentForm").submit();
            } else if(window.messageSend) {
                $("#MessageSendForm").submit();    
            } else {
                window.location.reload();
            }
        };
        
        if(checkClosed()) {
            googleAuthorised();
        }
        
    });
}

function getUserId() {
    var request = 
    $.ajax(window.location.origin + '/users/getCurrentUserId',
    {
        type: "POST",
        dataType: "JSON",
        async: false
    });
    request.done(function(data){
       window.userId = parseInt(data.id, 10); 
    });
}

/*
function postComment(userId){
    if($(".comment-box").val() === ""){
        return;
    }
    
    var commentContent = $(".comment-box").val();
    var ideaId = $("#idea-id").text();
    
    var request = 
    $.ajax(window.location.origin + "/comments/reply/",
    {
        type: "POST",
        data: 
            {
                ideaId : ideaId,
                parentId : -1,
                content : commentContent
            },
        dataType: "JSON"
    });

    request.done(function(data){
        //$('.replyArea').remove();
        var element = $(data.comment);
        $(element).insertAfter("#comments-title");
        $(element).children().first().children().first().children(".comment-upvote-switch").children(".bootstrap-switch").bootstrapSwitch();
        initialiseLinks();
    });

}
*/