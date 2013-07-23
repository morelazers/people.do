var replying = false;

$(document).ready(function() {
	$('.replyToCommentButton').click(function(event){
        event.preventDefault();
		if($(this).text() === 'Reply'){
			$(this).text('Cancel');
            replying = true;
		} else {
			$(this).text('Reply');
            replying = false;
		}
	});
});

function showReplyBox(commentId, userId){
    if(replying){
        $('#Comment'+commentId).append("<div class='replyArea'><br /><textarea id='ReplyToCommentTextArea"+commentId+"' rows='3' cols='30' required='required'></textarea>"+
        "<br /><button class='submitCommentReply' onclick='replyToComment("+commentId+", "+userId+")'>Submit Reply</button></div>");
    } else {
        $('.replyArea').remove();
    }
}

function replyToComment(commentId, userId){
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
        $('#Comment'+commentId).append("<div class='commentChild'>"+data.comment+"</div>");
        $('.replyArea').remove();
    });

}