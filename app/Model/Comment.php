<?php
class Comment extends AppModel {
    public $hasMany = 'CommentUpvote';
}
?>