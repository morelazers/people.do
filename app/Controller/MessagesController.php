<?php
class MessagesController extends AppController {
  
    public $helpers = array('Html', 'Form', 'Session', 'Js');
    public $components = array('Session', 'RequestHandler');
    
    public function index() 
    {
        $user = $this->Auth->user();
        $uid = $user['User']['id'];
        $this->set('messages', 
            $this->Message->find('all', 
                array(
                    'conditions' => array(
                        'Message.to_user_id' => $uid
                    )
                )
            )
        );
    }
  
    public function send() 
    {
        if($this->request->is('post')) {
            $user = $this->Auth->user();
            $uid = $user['User']['id'];
            $this->Message->create();
            $this->request->data['Message']['from_user_id'] = $uid;
            $this->request->data['Message']['to_user_id'] = $this->Message->getIdFromUsername($this->request->data['Message']['recipient']);
            // Send the message:
            $this->Message->save($this->request->data);
        }
    }
  
}
?>