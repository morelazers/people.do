<?php 
class IdeaUpvote extends AppModel{
    public $recursive = -1;
    public $belongsTo = array('Idea', 'User');
}
?>