<?php
App::uses('AuthComponent', 'Controller/Component');
class GoogleUser extends AppModel{
	public $belongsTo = 'User';

	public function addUser($raw){
		$user = array();
		$user['display_name'] = $raw['auth']['info']['name'];
		$user['email_address'] = $raw['auth']['info']['email'];
		if(isset($raw['auth']['info']['image'])){
			$user['avatar_location'] = $raw['auth']['info']['image'];
		}
		$user['google_user'] = 1;

		$this->User->create();
		$this->User->save($user);

		$user = array();
		$user['google_id'] = $raw['auth']['raw']['id'];
		$user['user_id'] = $this->User->id;
		$user['token'] = $raw['auth']['credentials']['token'];
		$this->create();
		$this->save($user);
	}
}
?>