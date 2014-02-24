<?php
class MessagesController extends AppController {
  
    public $helpers = array('Html', 'Form', 'Session', 'Js');
    public $components = array('Session', 'RequestHandler');
    public $uses = array('Message', 'Comment', 'User');
    
    public function index() 
    {
        $user = $this->Auth->user();
        
        if(!$user){
          $this->redirect(array('controller' => 'ideas')); 
        }
        
        $uid = $user['User']['id'];
        
        $messages = $this->Message->find(
            'all', 
            array(
                'conditions' => array(
                    'Message.to_user_id' => $uid
                ),
                'order' => array('Message.created DESC')
            )
        );
        
        $this->Message->updateAll(array('Message.is_read' =>'1'), array('Message.to_user_id' => $uid));
        
        $user = $this->Message->Recipient->findById($uid);
        
        $user['User'] = $user['Recipient'];
        unset($user['Recipient']);
        
        $this->Auth->login($user);
        
        $this->set(array(
            'messages' => $messages,
            'user' => $user
            )
        );
    }
  
    public function send($username = null) 
    {
        $user = $this->Auth->user();
        
        if(!isset($user)){
          $this->redirect(array('controller' => 'ideas')); 
        }
        
        if(!isset($username)){
            $this->Session->setFlash("Can't send a message to nobody!");
            $this->Redirect('/');
        }
        
        $toUser = $this->User->findByUsername($username);
        if(empty($toUser)){
            $this->Session->setFlash("That user doesn't exist!");
            $this->Redirect('/');
        }
        
        if($this->request->is('post')) {
            //$user = $this->Auth->user();
            $uid = $user['User']['id'];
            $this->Message->create();
            $this->request->data['Message']['from_user_id'] = $uid;
            $id = $this->Message->getIdFromUsername($username);
            $this->request->data['Message']['to_user_id'] = $id;
            $this->request->data['Message']['is_read'] = 0;
            // Send the message:
            $this->Message->save($this->request->data);
            $this->Session->setFlash('Message sent!');
            $this->redirect('/');
        }
        
        $this->set(array(
            'toUser' => $toUser
            )
        );
    }
    
    public function reply(){
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $content = $this->request->data['content'];
            $user = $this->Auth->user();
            $userId = $user['User']['id'];
            $toUser = $this->request->data['toUser'];
            $parentId = $this->request->data['pId'];
            $subject = "RE: ".$this->request->data['subject'];
            
            if(intval($parentId) !== 0){
                $this->Comment->create();
                
                $oldComment = $this->Comment->findById($parentId);
                $ideaId = $oldComment['Comment']['idea_id'];
                
                $comment = array(
                    'content' => $content,
                    'user_id' => $userId,
                    'idea_id' => $ideaId,
                    'parent_id' => $parentId
                    );
                $this->Comment->save($comment);
                
                $user = $this->User->findById($userId);
                
                $subject = $user['User']['display_name'].' replied to your comment!';
            }
            
            $this->Message->create();
            
            $data = array(
                'from_user_id' => $userId,
                'to_user_id' => $toUser,
                'content' => $content,
                'subject' => $subject
            );
            
            $this->Message->save($data);
            echo json_encode(array('content' => $content));
            
        }
    }
  
}
?>