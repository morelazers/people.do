<?php
class Comment extends AppModel {
    
    // Tree structure makes it much easier to thread comments
    public $actsAs = array('Tree');
    
    public $hasMany = array(
        'CommentUpvote',
        'Children' => array(
            'className' => 'Comment',
            'foreignKey' => 'parent_id'
        )
    );
    
    public $belongsTo = array(
        'Idea',
        'Parent' => array(
            'className' => 'Comment',
            'foreignKey' => 'parent_id'
        ),
        'User'
    );

    public $validate = array(
        'content' => array(
            'rule' => 'notEmpty'
        )
    );
    
    /**
     * Notifies the poster of a comment of a reply to that comment
     *
     * @param uid - the id of the current user
     * @param data - the data array of the new comment
     * @param parent - the id of the parent comment
     * @param newId - the id of the new comment
     */
    public function notifyPoster($uid, $data, $parent, $newId) {
      $parentComment = $this->findById($parent);
      $user = $this->User->findById($uid);
      
      // dont do anything if we're replying to our own comment
      if($parentComment['Comment']['user_id'] !== $uid){
        $toId = $parentComment['Comment']['user_id'];
    
        $message['content'] = $data['Comment']['content'];
        $message['subject'] = $user['User']['display_name']." replied to your comment!";
        
        $this->User->sendMessage($uid, $message, $toId, $newId);
      }
    }
    
    /**
     * Makes an upvote on the part of whoever posted the comment
     */
    public function afterSave($created) {
        $newId = $this->getLastInsertId();
        
        $comment = $this->findById($newId);
        
        $uid = $comment['Comment']['user_id'];
        $this->CommentUpvote->create();
        $newCommentUpvote = array(
            'comment_id' => $newId,
            'user_id' => $uid
        );
        $this->CommentUpvote->save($newCommentUpvote);
    }

}
?>