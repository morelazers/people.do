<!-- File: /app/View/Ideas/view.ctp -->

<?php echo $this->Html->script('ajax_upvote'); ?>
<?php echo $this->Html->script('ajax_replyToComment'); ?>

<h1><?php echo h($idea['Idea']['name']); ?></h1>
<div id="ideaId" display="none"><?php echo $idea['Idea']['id']; ?></div>

<p><small>Posted by: <?php echo $idea['Idea']['posted_by_name']; ?></small></p>

<p>Upvotes: </p>
<div id="IdeaUpvoteCount">
    <?php echo $idea['Idea']['upvotes']; ?>
</div>

<p><?php echo h($idea['Idea']['description']); ?></p>

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

<hr>

<?php foreach ($comments as $comment): ?>

<tr>
    <?php 
        echo $this->element('comment', array(
                                    'comment' => $comment,
                                    'commentUpvotes' => $commentUpvotes,
                                    'user' => $user
                                    
                                    ));
    ?>
</tr>
<?php endforeach; ?>
<?php unset($comment); ?>

<?php

    /* Show the comment form at the bottom of the list of comments */

    if(!$user){
        ?>
        <textarea rows="3"></textarea><br />
        <button class="loginRequired">Submit Comment</button>
        <?php
    } else {
        echo $this->Form->create('Comment');
        echo $this->Form->input('Comment', array('rows' => '3'));
        echo $this->Form->end(array(
            'label' => 'Submit Comment',
            'id' => 'SubmitComment'
        ));
    }

    echo $this->Js->writeBuffer();
?>