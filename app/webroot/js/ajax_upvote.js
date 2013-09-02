$(document).ready(function(){
    if(userIsLoggedIn){
        $("#UpvoteIdea").click(function(){
            $(this).toggleClass("voted");
            votes = parseInt($("#IdeaUpvoteCount").text());
            if($(this).hasClass("voted")){
                votes = votes + 1;
            } else {
                votes = votes - 1;
            }
            $("#IdeaUpvoteCount").text("" + votes);
        });
        
        $(".upvoteComment").click(function(){
            $(this).toggleClass("voted");
            var id = this.id.slice(13);
            var votes = parseInt($("#CommentUpvoteCount" + id).text(), 10);
            if($(this).hasClass("voted")){
                votes = votes + 1;
            } else {
                votes = votes - 1;
            }
            $("#CommentUpvoteCount" + id).text(votes);
        });
    }
});

function upvoteComment(commentId, votes, userId){
    
    var request = 
    $.ajax(window.location.origin + "/comments/upvote/",
    {
        type: "POST",
        data: 
            {
                id : commentId,
                upvotes : votes,
                uid : userId
            },
        dataType: "JSON"
    });
}

function upvoteIdea(ideaId, votes, userId){
    var request = 
    $.ajax(window.location.origin + "/ideas/upvote/",
    {
        type: "POST",
        data: 
            {
                id : ideaId,
                upvotes: votes,
                uid : userId
            },
        dataType: "JSON"
    });
}