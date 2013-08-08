$(document).ready(function() {
    $('.replyToMessageButton').click(function(event){
        event.preventDefault();
	});
});

function showReplyBox(messageId, userId, toUserId, parentId){
    
    var thisButton = $('#ReplyToMessage'+messageId);
    
    if(thisButton.text() === 'Reply'){
        thisButton.text('Cancel');
        var element = $("<div class='replyArea' id='ReplyArea"+messageId+"'><br /><textarea id='ReplyToMessageTextArea"+messageId+"' rows='3' cols='30' required='required'></textarea>"+
        "<br /><button class='submitMessageReply' onclick='replyToMessage("+messageId+", "+userId+", "+toUserId+", "+parentId+")'>Submit Reply</button></div>");
        $(element).insertAfter("#ReplyToMessage"+messageId);
    } else {
        thisButton.text('Reply');
        $('#ReplyArea'+messageId).remove();
    }
}

function replyToMessage(messageId, userId, toUserId, parentId){
    if($("#ReplyToMessageTextArea"+messageId).val() === ""){
        return;
    }
    var messageContent = $("#ReplyToMessageTextArea"+messageId).val();
    
    var subject = $("#Subject"+messageId).val();
    
	var request = 
    $.ajax(window.location.origin + "/messages/reply/",
    {
        type: "POST",
        data: 
            {
                pId : parentId,
                content : messageContent,
                uid : userId,
                toUser: toUserId,
                subject : subject
            },
        dataType: "JSON"
    });
    
    request.done(function(message){
        $('.replyArea').remove();
        $('#ReplyToMessage'+messageId).text('Reply');
        var element = $("<div class='messageReply'>"+message.content+"</div>");
        $(element).insertAfter("#ReplyToMessage"+messageId);
    });

}