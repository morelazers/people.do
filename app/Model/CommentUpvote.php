<?php 
class CommentUpvote extends AppModel{
    public $belongsTo = array('Comment', 'User');
}
?>