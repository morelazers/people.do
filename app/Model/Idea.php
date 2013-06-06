<?php
class Idea extends AppModel 
{
    public $hasMany = array('Comment', 'IdeaUpvote');
    
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty'
        ),
        'description' => array(
            'rule' => 'notEmpty'
        )
    );
    
    public function isOwnedBy($post, $user) 
    {
        return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
    }
    
}
?>