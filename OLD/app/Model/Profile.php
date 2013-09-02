<?php
App::uses('AuthComponent', 'Controller/Component');
class Profile extends AppModel{
	public $belongsTo = 'User';
}
?>