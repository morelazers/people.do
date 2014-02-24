<!-- File: /app/View/Ideas/view.ctp -->

<?php echo $this->Html->script('ajax_upvote'); ?>
<?php echo $this->Html->script('ajax_replyToComment'); ?>

<?php echo $this->start('topbar'); ?>

<div id="UpvoteButtonContainer">
<?php 

    /* If the user is logged in, display the upvote and reply links. If not, replace the links with a login popup */

    $user = $this->session->read('Auth.User'); 
    if(!$user){
        ?>
        <a class="loginRequired">
            <img src="/img/transparent.png" class="upvoteIdea"></img>
            <span id="IdeaUpvoteCount" class="count">
                <?php echo $idea['Idea']['upvotes']; ?>
            </span>
        </a>
        <?php
    } else {
        $class = '';
        foreach($ideaUpvotes as $vote){
            if($vote['Idea']['id'] === $idea['Idea']['id'] && $vote['User']['id'] === $user['User']['id']){
                $class = ' voted';
            }
        }
        
        ?>
         <a>
            <img src="/img/transparent.png" class="upvoteIdea<?php echo $class; ?>"></img>
            <span id="IdeaUpvoteCount" class="count<?php echo $class; ?>">
                <?php echo $idea['Idea']['upvotes']; ?>
            </span>
         </a>
        <?php
        $eventCode = 'upvoteIdea('.$idea['Idea']['id'].', '.$idea['Idea']['upvotes'].', '.$user['User']['id'].')';
        echo $this->Js->get('.upvoteIdea')->event('click', $eventCode, array('wrap' => true));
    }
?>

</div>

<div id="IdeaInfo">
    <div id="IdeaName">
        <h1><?php echo h($idea['Idea']['name']); ?></h1>
    </div>
    <div id="ideaId" style="display:none"><?php echo $idea['Idea']['id']; ?></div>
    Brainchild of: 
    <?php
        echo $this->Html->link($idea['Idea']['shared_by_name'], 
        array('controller' => 'profiles', 'action' => 'view', $idea['Idea']['user_id']), array('class' => 'topBarLink'));
    ?>
</div>

<?php 

    if($user['User']['id'] === $idea['Idea']['user_id']){
        ?>
        <span id="EditLink"><a href="/ideas/edit/<?php echo $idea['Idea']['id']; ?>">Edit</a></span>
        <?php
    }

?>


<?php echo $this->end(); ?>

<div id="IdeaDescription">
<br />
<p><?php echo nl2br($idea['Idea']['description']); ?></p>
</div>

<hr class="viewHr"></hr>

<div id="CommentsAndForm">

<?php

    /* Show the comment form above the list of comments */

    if(!$user){
        $class = 'loginRequired';
    } else {
        $class = 'commentSubmitButton';
    }
    echo $this->Form->create('Comment', array('id' => 'CommentForm'));
    
    if(isset($user)){
        echo $this->Form->hidden(
            'UserId', 
            array('value' => $user['User']['id'])
        );
    }
    
    echo $this->Form->input('content', array(
        'rows' => '7',
        'id' => 'commentBox',
        'label' => 'Leave a comment!'
        )
    );
    $options = array(
        'label' => 'Submit Comment',
        'id' => 'SubmitComment',
        'class' => $class
    );
    echo $this->Form->end($options);

    echo $this->Js->writeBuffer();
?>

<hr class="viewHr"></hr>

<?php foreach ($comments as $comment): ?>

<tr>
    <?php 
        if(empty($comment['Parent']['id'])){
            echo $this->element(
                'comment', array(
                    'comment' => $comment,
                    'commentUpvotes' => $commentUpvotes,
                    'user' => $user
                )
            );
        }
    ?>
</tr>
<?php endforeach; ?>
<?php unset($comment); ?>

</div>