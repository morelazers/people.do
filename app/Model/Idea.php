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
    
    public function isOwnedBy($idea, $user)
    {
        return $this->field('id', array('id' => $idea, 'user_id' => $user)) === $idea;
    }
    
    
    /**
     * Notifies whoever posted the idea of a new comment, unless they shared the idea
     *
     * @param uid - the id of the current user
     * @param data - an array of the comment posted
     * @param ideaOwner - the id of the sharer of the idea
     * @param newId - the id of the new comment
     */
    public function notifyPoster($uid, $data, $ideaOwner, $newId){
      
      // don't do anything if we shared the idea
      if($uid !== $ideaOwner){
        
        // get the user who posted the comment
        $user = $this->User->findById($data['Comment']['UserId']);
        
        $commentContent = $data['Comment']['content'];
        $subject = "There's a new comment on your idea from ".$user['User']['display_name']."!";
        
        $message = array(
            'content' => $commentContent,
            'subject' => $subject
        );
        
        $this->User->sendMessage($uid, $message, $ideaOwner, $newId);
      }
    }
    
    /**
     * Makes an automatic upvote on the part of the user that shared the idea
     */
    public function afterSave($created) {
      
        $ideaId = $this->getLastInsertId();
        $idea = $this->findById($ideaId);
        
        if($idea){
            $uid = $idea['Idea']['user_id'];
        
            $this->IdeaUpvote->create();
            $newIdeaUpvote = array(
                'idea_id' => $ideaId,
                'user_id' => $uid
            );
            $this->IdeaUpvote->save($newIdeaUpvote);
        }
        
        $ideaInterest['idea_id'] = $ideaId;
    }
    
    
}
?>