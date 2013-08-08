<?php
class Message extends AppModel {
    
    public $belongsTo = array(
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'from_user_id'
        ),
        'Recipient' => array(
            'className' => 'User',
            'foreignKey' => 'to_user_id'
        )
    );
    
    public $validate = array(
        'recipient' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'You can\'t sent a message to nobody!'
            )
        ),
        'subject' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your message needs a subject!'
            )
        ),
        'content' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'There\'s no point sending a blank message!'
            )
        )
    );
    
    public function getIdFromUsername($username){
        $result = $this->User->findByUsername($username);
        if(!$result) {
            return null;
        }
        return $result['User']['id'];
    }
}
?>