<!-- File: /app/View/Ideas/view.ctp -->

<?php echo $this->Html->script('ajax_upvote'); ?>
<?php echo $this->Html->script('ajax_replyToComment'); ?>

<?php echo $this->start('topbar'); ?>
<h1><?php echo h($idea['Idea']['name']); ?></h1>
<div id="ideaId" style="display:none"><?php echo $idea['Idea']['id']; ?></div>

<p><small>Brainchild of: 
<?php
    echo $this->Html->link($idea['Idea']['shared_by_name'], 
    array('controller' => 'profiles', 'action' => 'view', $idea['Idea']['user_id']), array('class' => 'topBarLink'));
?>
</small></p>

<p>Upvotes: 
    <span id="IdeaUpvoteCount">
        <?php echo $idea['Idea']['upvotes']; ?>
    </span>
</p>

<?php 

    /* If the user is logged in, display the upvote and reply links. If not, replace the links with a login popup */

    $user = $this->session->read('Auth.User'); 
    if(!$user){
        ?>
        <button class="loginRequired">Upvote</button>
        <?php
    } else {
        $class = 'upvoteIdea';
        foreach($ideaUpvotes as $vote){
            if($vote['Idea']['id'] === $idea['Idea']['id'] && $vote['User']['id'] === $user['User']['id']){
                $class = 'upvoteIdea voted';
            }
        }
        echo $this->Html->link('Upvote', '', array('class' => $class, 'id' => 'UpvoteIdea'));
        $eventCode = 'upvoteIdea('.$idea['Idea']['id'].', '.$idea['Idea']['upvotes'].', '.$user['User']['id'].')';
        echo $this->Js->get('#UpvoteIdea')->event('click', $eventCode, array('wrap' => true));
    }
?>

<?php echo $this->end(); ?>

<div id="IdeaDescription">
<br />
<p><?php echo nl2br($idea['Idea']['description']); ?></p>
</div>
<hr>

<div id="CommentsAndForm">

<?php

    /* Show the comment form at the bottom of the list of comments */

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
        'rows' => '3',
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

<hr>

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