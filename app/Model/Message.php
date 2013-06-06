<?php
class Message extends AppModel {
    
    public $belongsTo = array(
        'User' => array(
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
        pr($result);
        return $result['User']['id'];
    }
}
?>