<?php
class MessagesController extends AppController {
  
    public $helpers = array('Html', 'Form', 'Session', 'Js');
    public $components = array('Session', 'RequestHandler');
    
    public function index() 
    {
        $this->set('messages', 
            $this->Message->find('all', 
                array(
                    'conditions' => array(
                        'Message.to_user_id' => $this->Auth->user('id')
                    )
                )
            )
        );
    }
  
    public function send() 
    {
        if($this->request->is('post')) {
            $this->Message->create();
            $this->request->data['Message']['from_user_id'] = $this->Auth->user['id'];
            $this->request->data['Message']['to_user_id'] = $this->Message->getIdFromUsername($this->request->data['Message']['recipient']);
            pr($this->request->data);
            // Send the message:
            $this->Message->save($this->request->data);
        }
    }
  
}
?>