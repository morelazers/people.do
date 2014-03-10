<?php
//debug($data);
$upvotes = $idea['Idea']['upvotes'];

$ideaChecked = "";
if($ideaUpvotes){
  $ideaChecked = " checked ";
  $upvotes--;
}
$requireLoginClass = "";
if(!$user){
  $requireLoginClass = " login-required";
}

?>

<div id="idea-content" class="col-lg-5 text-left scrollable">
  <div id="idea-id"><?php echo $idea['Idea']['id']; ?></div>
  <div id="current-idea-title" class="row text-right">
    <h3><?php echo $idea['Idea']['name']; ?></h3>
  </div>
  <div class="row">
    <span class="idea-submitter-name pull-right text-right">
      <h5><strong>Brainchild of: <a href="/user/<?php echo $idea['User']['username']; ?>"><?php echo $idea['Idea']['shared_by_name']; ?></a></strong></h5>
    </span>
    <span class="upvote-switch pull-left">
      <input id="upvote-idea" type="checkbox" <?php echo $ideaChecked; ?>class="bootstrap-switch pull-left<?php echo $requireLoginClass; ?>" data-on-label="<?php echo intval($upvotes + 1); ?>" data-off-label="<?php echo $upvotes; ?>">
    </span>
  </div>

  <div id="idea-description" class="row text-left">
    <?php echo $idea['Idea']['description']; ?>
  </div>
  <div id="idea-comment">
    <div id="comment-box-top" class="row">
      <textarea rows="4" class="comment-box"></textarea>
    </div>
    <button id="comment-post-top" class="row btn btn-default<?php echo $requireLoginClass; ?>">
      Comment
    </button>
  </div>

  <div id="idea-comments" class="row">
    <div id="comments-title">
      <h4><?php echo count($idea['Comment']); ?> Comments</h4>
    </div>
    <?php
    foreach($comments as $comment){
      echo $this->element('comment', array(
        'comment' => $comment,
          'commentUpvotes' => $commentUpvotes,
          'user' => $user,
          'child' => false
        )
      );
    }
    ?>
  </div>
</div>