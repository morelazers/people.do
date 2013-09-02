<?php
class Idea extends AppModel 
{
    public $hasMany = array('Comment', 'IdeaUpvote', 'IdeaInterest');
    public $belongsTo = array('User');
    
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'You need to give your idea a name!'
        ),
        'description' => array(
            'rule' => 'notEmpty',
            'message' => 'You need to describe your idea!'
        )
    );
    
    public function isOwnedBy($post, $user) 
    {
        return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
    }
    
    public function notifyPoster($uid, $data, $ideaOwner, $newId){
        
        $user = $this->User->findById($data['Comment']['UserId']);
        
        $commentContent = $data['Comment']['content'];
        $subject = "You have a new reply from ".$user['User']['display_name']."!";
        
        $message = array(
            'content' => $commentContent,
            'subject' => $subject
        );
        
        $this->User->sendMessage($uid, $message, $ideaOwner, $newId);
    }
    
    public function afterSave() {
        $ideaId = $this->getLastInsertId();
        
        $idea = $this->findById($ideaId);
        
        $uid = $idea['Idea']['user_id'];
        
        $this->IdeaUpvote->create();
        $newIdeaUpvote = array(
            'idea_id' => $ideaId,
            'user_id' => $uid
        );
        $this->IdeaUpvote->save($newIdeaUpvote);
    }
    
}
?>