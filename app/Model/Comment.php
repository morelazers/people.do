<?php
class Comment extends AppModel {
    public $hasMany = array(
        'CommentUpvote',
        'Children' => array(
            'className' => 'Comment',
            'foreignKey' => 'parent_comment_id'
        )
    );
    
    public $belongsTo = array(
        'Idea',
        'Parent' => array(
            'className' => 'Comment',
            'foreignKey' => 'parent_comment_id'
        )
    );

    public $validate = array(
        'comment' => array(
            'rule' => 'notEmpty'
        )
    );

}
?>