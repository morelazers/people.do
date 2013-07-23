<?php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel
{
    public $hasOne = array('GoogleUser', 'FacebookUser', 'Profile');
    //public $hasMany = array('IdeaUpvote');

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'repeat_password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Must be equal to your password'
            )
        ),
        'email_address' => 'email'
    );
    
    public function beforeSave($options = array()) 
    {
        // Hash the new user's password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

    public function afterSave($created){
        // Create a profile for the new user
        if($created){
            $this->Profile->create();
            $data = array();
            $data['user_id'] = $this->id;
            $this->Profile->save($data);
        }
        
    }
}
?>