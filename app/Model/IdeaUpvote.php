<?php 
class IdeaUpvote extends AppModel{
    public $belongsTo = array('Idea', 'User');
}
?>