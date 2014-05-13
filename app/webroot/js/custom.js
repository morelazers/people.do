function initialiseNewCommentSwitch(){
  $('.new-comment').bootstrapSwitch();
  $('.new-comment').removeClass('new-comment');
  $('.comment-box').val('');
}

function addNewCommentThread(el){
  $("#comments-title").after(el);
  initialiseNewCommentSwitch();
}

function addCommentReply(rb, el){
  rb.parent().next().after($(el));

  console.log($(el).find('.reply-button'));

  initialiseNewCommentSwitch();

  console.log(rb.parent().parent().find('.reply-button').eq(1));

  rb.parent().parent().children().find('.reply-button').eq(1).on("click", function(){
    console.log("FUCK");
    console.log($(this));
    changeReplyButtonText($(this));
  });

  rb.parent().remove();
}

function postComment(btn, pid){
  var commentContent;
  if(pid === -1){
    commentContent = $('.comment-box').val();
  } else {
    commentContent = btn.prev().val();
  }
  if(commentContent === ""){
   return;
  }
  var ideaId = $("#idea-id").text();
  var parentCommentId = pid;
  var request =
  $.ajax(window.location.origin + "/comments/reply/",
  {
    type: "POST",
    data:
      {
        ideaId : ideaId,
        parentId : parentCommentId,
        content : commentContent
      },
    context: this,
    dataType: "JSON"
  });
  request.done(function(data){
    var element = (data.comment);
    if(pid !== -1){
      btn.parent().next().children(".reply-button").text('Reply');
      addCommentReply(btn, element);
    } else {
      addNewCommentThread(element);
    }
    //initialiseLinks();
  });

}

function initialiseCommentButton(){
  $("#comment-post-top").on('click', function(event){
    postComment($(this), -1);
  });
}

function handleCommentReplySubmit(submitbtn){
  var parentCommentId = submitbtn.parent().siblings(".comment-info").children(".comment-id").html();
  postComment(submitbtn, parentCommentId);
}

function initialiseCommentReplyButton(){
  if(window.userIsLoggedIn){
    $(".submit-comment-reply").on('click', function(event){
      handleCommentReplySubmit($(this));
      //$(this).parent().next().children(".reply-button").text('Reply');
    });
  }

}

function initialiseModal(){
  $(".login-required").on('click', function(event){
    $('#LoginModal').modal('show');
    event.preventDefault();
    event.stopImmediatePropagation();
  });
}

function showCommentReplyArea(btn){
  var loginRequiredClass = " login-required";
  if(window.userIsLoggedIn){
    loginRequiredClass = "";
  }
  var element = $.parseHTML("<div class='comment-reply-area'><textarea class='comment-reply-textarea' rows='3' cols='30' required='required'></textarea>"+
    "<button class='btn btn-default submit-comment-reply" + loginRequiredClass + "'>Submit Reply</button></div>");

  btn.parent().before(element);
  var newel = btn.parent().parent().find(".submit-comment-reply").first();
  if(window.userIsLoggedIn){
    $(element).find(".submit-comment-reply").on('click', function(){
      handleCommentReplySubmit($(this));
    });
  }
  initialiseModal();
}

function removeCommentReplyArea(btn){
   btn.parent().prev().remove();
}


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

function initialiseUpvoteButtons(){
  if($("#upvote-checkbox").prop("checked") === true){
    $(".switch-container").addClass("flip");
  }
  $('#upvote-idea').on('click', function (e, data) {
    if(window.userIsLoggedIn){
      $(".switch-container").toggleClass("flip");
      $("#upvote-checkbox").prop("checked", !$("#upvote-checkbox").prop("checked"));
      upvoteIdea(parseInt($("#idea-id").html()));
    } else {
      $('#LoginModal').modal('show');
    }
  });


  $('.upvote-comment').on('click', function (e, data) {
    if(window.userIsLoggedIn){
      var element = $(data.el);
      upvoteComment(parseInt(element.parent().parent().parent().parent().siblings().last().html()));
    } else {
      $('#LoginModal').modal('show');
    }
  });

}

function initialiseIdeaTitles(){
  $(".idea-list-title").on('click', function(event){
    $(".idea").removeClass("active");
    $(this).parent().addClass("active");
    var ideaId = $(this).parent().children().last().html();
    loadIdea(ideaId);
  });
}

function changeReplyButtonText(btn){
  if(btn.text() === "Reply"){
    btn.text('Cancel');
    showCommentReplyArea(btn);
  } else {
    btn.text('Reply');
    removeCommentReplyArea(btn);
  }
}

function initialiseReplyButtons(){
   $(".reply-button").on('click', function(event){
    changeReplyButtonText($(this));
  });
}


function initialiseLinks(){
  //$('.bootstrap-switch').bootstrapSwitch();
  if(window.userIsLoggedIn){
    initialiseCommentButton();
  }
}

function initialiseShareButton(){
  if(window.userIsLoggedIn){
    $("#IdeaAddForm").on("submit", function(event){
      event.preventDefault();
      var request =
      $.ajax(window.location.origin + '/ideas/ajaxShare',
      {
        type: "POST",
        data: $(this).serialize(),
        dataType: "JSON"
      });
      request.done(function(data){
        window.location.replace('/' + data.newid);
      });
    });
  }
}

function loadIdea(id){
  var request =
    $.ajax(window.location.origin + "/ideas/ajaxview",
    {
      type: "POST",
      data:
        {
          ideaId : id
        },
      context: this,
      dataType: "JSON"
    });
    request.done(function(data){
      $("#idea-content-panel").html(data.markup);
      // $('.bootstrap-switch').bootstrapSwitch();
      initialiseLinks();
      initialiseUpvoteButtons();
      initialiseModal();
      initialiseReplyButtons();
      window.history.pushState("", "people.do", "/" + $('#idea-id').html());
      var h=$(window).height();
      $('#idea-content').height(h+'px');
      
      var idearow = $('.idea-list-id:contains("'+id+'")').parent();

      idearow.addClass("active");
      
    });
}

function replyToMessage(subject, content, toUserId, parentId, btn){
	var request =
    $.ajax(window.location.origin + "/messages/reply/",
    {
        type: "POST",
        data:
            {
                pId : parentId,
                content : content,
                toUser: toUserId,
                subject : subject
            },
        dataType: "JSON"
    });

    return request.done(function(message){
        //$('.reply-area').remove();
        //$('#ReplyToMessage'+messageId).text('Reply');
        var element = $("<div class='message-reply'>"+message.content+"</div>");
        element.insertAfter(btn.parent().siblings().last());
        btn.parent().remove();
        return element;
    });
}

function showMessageReplyBox(btn){
  btn.prop('disabled', true);
  var element =       "<div class='message-reply-area form-group'>";
  element = element +   "<textarea rows='3' class='message-reply-textarea form-control'></textarea>";
  element = element +   "<button class='btn-send-reply-to-message btn btn-default'>Send</button>";
  element = element +   "<button class='btn-cancel-reply-to-message btn btn-default'>Cancel</button>";
  element = element + "</div>";

  var newel = $.parseHTML(element);
  btn.parent().append(newel);
  initialiseMessageReplyCancelButton(btn.parent().children().last().children().last());
  initialiseMessageSendButton(btn.parent().children().last().children().first().next());
}

function initialiseMessageSendButton(sendbtn){
  $(sendbtn).on('click', function(){
    var subject = $(this).parent().parent().find('.subject').text();
    var content = $(this).parent().find('.message-reply-textarea').val();
    var toid = parseInt($(this).parent().parent().find('.from-id').text());

    console.log($(this).parent().parent().find('.from-id'));
    console.log(toid);

    var parentid = parseInt($(this).parent().parent().find('.parent-id').text());
    if(content !== ''){
      replyToMessage(subject, content, toid, parentid, $(this));
      sendbtn.parent().parent().find('.btn-reply-to-message').prop('disabled', false);
    }
  });
}

function initialiseMessageReplyButton(){
  $(".btn-reply-to-message").on('click', function(){
    showMessageReplyBox($(this));
  });
}

function initialiseMessageReplyCancelButton(cancelbtn){
   cancelbtn.on('click', function(){
     cancelbtn.parent().parent().find('.btn-reply-to-message').prop('disabled', false);
     cancelbtn.parent().remove();
   });
}

$(document).ready(function() {
    // make the swtches look nice
    //$('.bootstrap-switch').bootstrapSwitch();
    //initialiseLinks();

    var h=$(window).height();

    var topid = $("#idea-list").children().next().children().next().html();
    initialiseIdeaTitles();

    var urlextension = document.location.pathname.slice(1);

    if(urlextension == parseInt(urlextension, 10)){
      loadIdea(urlextension);
    } else if(
      (urlextension == "think" && !window.userIsLoggedIn)
      || ('http://people.do' == window.location.origin || 'http://localhost' == window.location.origin)
      ){
      loadIdea(topid);
    } else {
      loadIdea(topid);
    }

    // i'm in your monitor reading your screen size

    $('.scrollable').height(h+'px');
    $('#nav-panel').height(h+'px');

    initialiseModal();
    initialiseShareButton();

    initialiseMessageReplyButton();
});