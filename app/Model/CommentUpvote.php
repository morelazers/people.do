<?php 
class CommentUpvote extends AppModel{
  public $recursive = -1;
  public $belongsTo = array('Comment', 'User');
}
?>