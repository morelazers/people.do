<?php
class Comment extends AppModel {
    
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
    
    public function notifyPoster($uid, $data, $parent, $newId) {
        $parentComment = $this->findById($parent);
        $user = $this->User->findById($uid);
        
        if($parentComment['Comment']['user_id'] !== $uid){
            $toId = $parentComment['Comment']['user_id'];
        
            $message['content'] = $data['content'];
            $message['subject'] = $user['User']['display_name']." replied to your comment!";
            
            $this->User->sendMessage($uid, $message, $toId, $newId);
        }
    }
    
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