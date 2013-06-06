$(document).ready(function() {
    
    $(".upvoteIdeaButton").click(function(){
        $(this).toggleClass("voted");
    });
    
    $(".upvoteCommentButton").click(function(){
        $(this).toggleClass("voted");
    });
    
});

    
function upvoteComment(commentId, votes){
    
    
    var request = 
    $.ajax("http://www.dev.thinkshare.it/cakephp/comments/upvote/",
    {
        type: "POST",
        data: 
            {
                id : commentId,
                upvotes: votes
            },
        dataType: "html"
    });
    
    request.done(function(html){
        $("#commentUpvoteCount"+commentId).text(html);
    });
    
}

function upvoteIdea(ideaId, votes){
    
    var request = 
    $.ajax("http://www.dev.thinkshare.it/cakephp/ideas/upvote/",
    {
        type: "POST",
        data: 
            {
                id : ideaId,
                upvotes: votes
            },
        dataType: "html"
    });
    
    request.done(function(html){
        $("#ideaUpvoteCount").text(html);
    });
    
}