<!-- File: /app/View/Ideas/view.ctp -->

<?php echo $this->Html->script('ajax_upvote'); ?>

<h1><?php echo h($idea['Idea']['name']); ?></h1>

<p><small>Posted by: <?php echo $idea['Idea']['posted_by_name']; ?></small></p>

<p>Upvotes: </p>
<div id="ideaUpvoteCount">
    <?php echo $idea['Idea']['upvotes']; ?>
</div>

<p><?php echo h($idea['Idea']['description']); ?></p>

<?php
echo $this->Form->button('Upvote', array(
                                        'class' => 'upvoteIdeaButton',
                                        'onclick' => 'upvoteIdea('.$idea['Idea']['id'].', '.$idea['Idea']['upvotes'].')'
                                        ));
?>

<hr>

<?php foreach ($idea['Comment'] as $comment): ?>
<tr>
    <?php echo $comment['content'];?>
    <br />
    <div id="commentUpvoteCount<?php echo $comment['id']; ?>" class="commentUpvoteCount"><?php echo $comment['upvotes']; ?></div>
    <br />
    <?php 
    echo $this->Form->button('Upvote', array(
                                            'class' => 'upvoteCommentButton',
                                            'onclick' => 'upvoteComment('.$comment['id'].', '.$comment['upvotes'].')'
                                            ));
    ?>
    <hr>
</tr>
<?php endforeach; ?>
<?php unset($comment); ?>


<?php
echo $this->Form->create('Comment');
echo $this->Form->input('comment', array('rows' => '3'));
echo $this->Form->end('Submit Comment');

echo $this->Js->writeBuffer();
?>