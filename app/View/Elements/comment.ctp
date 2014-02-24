<?php 
if(!isset($child)){
    $child = false;
}

//debug($comment);

$thisComment = $comment['Comment'];
$commentPoster = $comment['User'];
$commentPosterName= $commentPoster['username'];
$upvotes = $thisComment['upvotes'];

$childClass = "";
if($child){
    $childClass = "-child";
}
$checked = '';
$disabled = false;
$class = '';
$new = '';
$login = ' login-required';
if($user){
  $login = '';
  if(isset($commentUpvotes)){
    if(in_array($thisComment['id'], $commentUpvotes)){
      $checked = ' checked ';
      $upvotes--;
    }
  } else if(isset($newComment)){
    $checked = ' checked ';
    $upvotes--;
    $new = " new-comment";
  }
}
?>

<div class="comment<?php echo $childClass; ?>">
  <div class="comment-info">
    <div>
    <span class="comment-username pull-left text-right">
      <a href="/users/<?php echo $commentPosterName; ?>"><?php echo $commentPosterName; ?></a>
    </span>
    <span class="comment-upvote-switch pull-right">
      <input type="checkbox" <?php echo $checked; ?>class="upvote-comment pull-right bootstrap-switch switch-mini<?php echo $login . $new; ?>" data-on-label="<?php echo intval($upvotes + 1); ?>" data-off-label="<?php echo $upvotes; ?>">
    </span>
    </div>
    <span class="comment-id"><?php echo $thisComment['id']; ?></span>
  </div>
  <div class="comment-body text-left">
    <?php echo nl2br($thisComment['content']); ?>
  </div>

  <div class="comment-reply-button">
    <button class="btn reply-button">Reply</button>
  </div> 
  <?php

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
