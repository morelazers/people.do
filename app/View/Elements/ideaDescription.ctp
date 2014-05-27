<?php
//debug($data);
$upvotes = $idea['Idea']['upvotes'];

if(!$link = $idea['User']['username']){
  $link = $idea['User']['id'];
}

$ideaChecked = "";
if(!empty($ideaUpvotes)){
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
      <h5><strong>Brainchild of: <a href="/user/<?php echo $link; ?>"><?php echo $idea['Idea']['shared_by_name']; ?></a></strong></h5>
    </span>
    <input id="upvote-checkbox" type="checkbox"<?php echo $ideaChecked; ?>class="pull-left">
    <div id="upvote-idea" class="switch-container" ontouchstart="this.classList.toggle('hover');">
      <div class="flipper">
        <div class="upvote-switch <?php echo $requireLoginClass; ?>">
          <div class="current-upvotes"><?php echo intval($upvotes); ?></div>
        </div>
        <div class="upvote-switch-checked">
          <div class="current-upvotes"><?php echo intval($upvotes + 1); ?></div>
        </div>
      </div>
    </div>
  </div>

  <div id="idea-description" class="row text-left">
    <?php echo nl2br($idea['Idea']['description']); ?>
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