$(document).ready(function(){
    if(userIsLoggedIn){
        $("#upvote-idea").click(function(){
            ideaId = parseInt($("#idea-id").html());
            upvoteIdea(ideaId);
        });
        
        $(".upvote-comment").click(function(){
            var id = $(this).parent().parent().parent().next().html()
            console.log(id);
            $(this).bootstrapSwitch('toggleState');
        });
    }
});

function upvoteComment(commentId){
    var request = 
    $.ajax(window.location.origin + "/comments/upvote/",
    {
        type: "POST",
        data: 
            {
                id : commentId
            },
        dataType: "JSON"
    });
}

function upvoteIdea(ideaId){
    var request = 
    $.ajax(window.location.origin + "/ideas/upvote/",
    {
        type: "POST",
        data: 
            {
                id : ideaId
            },
        dataType: "JSON"
    });
}