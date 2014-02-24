<?php
class FacebookUser extends AppModel{
	public $belongsTo = 'User';

	public function addUser($raw){
		$user = array();
		$user['display_name'] = $raw['auth']['info']['name'];
        if(isset($raw['auth']['raw']['email'])){
            $user['email_address'] = $raw['auth']['raw']['email'];
        }
		if(isset($raw['auth']['info']['image'])){
			$user['avatar_location'] = $raw['auth']['info']['image'];
		}
		$user['facebook_user'] = 1;

		$this->User->create();
		$this->User->save($user);

		$user = array();
		$user['facebook_link'] = $raw['auth']['raw']['link'];
		$user['user_id'] = $this->User->id;
		$user['token'] = $raw['auth']['credentials']['token'];
		$this->create();
		$this->save($user);
	}
}
?>