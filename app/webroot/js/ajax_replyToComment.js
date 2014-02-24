$(document).ready(function() {
	$('.reply-button').click(function(event){
	    console.log("click");
        if($(this).text() === "Reply"){
          $(this).text('Cancel');
        }
	});
});

function showReplyBox(commentId, userId){
    
    var thisButton = $('#ReplyToComment'+commentId);
    
    if(thisButton.text() === 'Reply'){
        thisButton.text('Cancel');
        var element = $("<div class='replyArea' id='ReplyArea"+commentId+"'><br /><textarea id='ReplyToCommentTextArea"+commentId+"' rows='3' cols='30' required='required'></textarea>"+
        "<br /><button class='submitCommentReply' onclick='replyToComment("+commentId+", "+userId+")'>Submit Reply</button></div>");
        $(element).insertAfter("#ReplyToComment"+commentId);
    } else {
        thisButton.text('Reply');
        $('#ReplyArea'+commentId).remove();
    }
}

function replyToComment(commentId, userId){
    if($("#ReplyToCommentTextArea"+commentId).val() === ""){
        return;
    }
    var commentContent = $("#ReplyToCommentTextArea"+commentId).val();
    var ideaId = $("#ideaId").text();
    
	  var request = 
    $.ajax(window.location.origin + "/comments/reply/",
    {
        type: "POST",
        data: 
            {
                ideaId : ideaId,
                parentId : commentId,
                content : commentContent,
                uid : userId
            },
        dataType: "JSON"
    });

    request.done(function(data){
        $('.replyArea').remove();
        $('#ReplyToComment'+commentId).text('Reply');
        var element = $("<div class='commentChild'>"+data.comment+"</div>");
        $(element).insertAfter("#ReplyToComment"+commentId);
    });

}