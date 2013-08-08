<?php 
    if(!isset($child)){
        $child = false;
    }
    
    $thisComment = $comment['Comment'];
?>

<div class="comment<?php if($child){ echo 'Child'; }?>" id="Comment<?php echo $thisComment['id']; ?>">
    <?php echo $thisComment['content']; ?>
    <br />
    <div id="CommentUpvoteCount<?php echo $thisComment['id']; ?>" class="commentUpvoteCount"><?php echo $thisComment['upvotes']; ?></div>
    <br />
    <?php 

        /* If the user is logged in, display the upvote and reply links. If not, show a login prompt on click */
        $disabled = false;
        if(!$user){
            ?>
            <button class="loginRequired">Upvote</button>
            <button class="loginRequired">Reply</button>
            <?php
        } else {
            $class = 'upvoteComment';
            if(isset($commentUpvotes)){
                foreach($commentUpvotes as $vote){
                    if($vote['CommentUpvote']['comment_id'] === $thisComment['id'] && $vote['User']['id'] === $user['User']['id']){
                        $class = 'upvoteComment voted';
                    }
                }
            } else if(isset($thisComment['user_id']) && $thisComment['user_id'] === $user['User']['id']) {
                $class = 'upvoteComment voted';
                $disabled = true;
            }
            
            echo $this->Form->button('Upvote', array('type' => 'button', 'class' => $class, 'id' => 'UpvoteComment'.$thisComment['id'], 'disabled' => $disabled));
            $upvoteEventCode = 'upvoteComment('.$thisComment['id'].', '.$thisComment['upvotes'].', '.$user['User']['id'].')';
            echo $this->Js->get('#UpvoteComment'.$thisComment['id'])->event('click', $upvoteEventCode, array('wrap' => true));
            echo ' ';
            echo $this->Form->button('Reply', array('type' => 'button', 'class' => 'replyToCommentButton', 'id' => 'ReplyToComment'.$thisComment['id']));
            $replyEventCode = 'showReplyBox('.$thisComment['id'].', '.$user['User']['id'].')';
            echo $this->Js->get('#ReplyToComment'.$thisComment['id'])->event('click', $replyEventCode, array('wrap' =>true));
        }
        
        if(!empty($comment['children'])){
            foreach($comment['children'] as $comment){
                echo $this->element(
                    'comment', array(
                        'comment' => $comment,
                        'commentUpvotes' => $commentUpvotes,
                        'user' => $user,
                        'child' => true
                    )
                );
            }
        }
        
    ?>
</div>
<hr>