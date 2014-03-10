<?php
class ProfilesController extends AppController{

    public $components = array('Session', 'RequestHandler');
    public $uses = array('Interest', 'User', 'Profile');

	public function index(){

		// Get the currently logged in user
		$user = $this->Auth->user();

        if (!$user) {
            $this->redirect(array('controller' => 'ideas', 'action' =>'index'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

        	// Align the being-edited profile with the one in the database
            $profile['Profile']['id'] = $user['Profile']['id'];
            $profile['Profile']['user_id'] = $user['User']['id'];
            $profile['Profile']['about_me'] = $this->request->data['Profile']['about_me'];

            $userInterest['user_id'] = $user['User']['id'];

            $this->Profile->User->UserInterest->deleteAll(array('UserInterest.user_id' => $userInterest['user_id']));

            if(!empty($this->request->data['Interest']['id'])){
                foreach($this->request->data['Interest']['id'] as $id){
                    if(!is_numeric($id) && !$this->Interest->findByName($id)){
                        $this->Interest->saveNewInterest($id, $user['User']['id']);
                        $id = $this->Interest->getLastInsertId();
                    }
                    if(!$this->Profile->User->UserInterest->findByUserIdAndInterestId($userInterest['user_id'], $id)) {
                        $userInterest['interest_id'] = $id;
                        $this->Profile->User->UserInterest->create();
                        $this->Profile->User->UserInterest->save($userInterest);
                    }
                }
            }

            if ($this->Profile->save($profile)) {
                $user = $this->User->findById($user['User']['id']);
                $this->Auth->login($user);
                $this->redirect(array('action' => 'index'));
            }
        }

        $interests = $this->Interest->find('all');
        $user = $this->User->findById($user['User']['id']);

        $interestNames = array();
        foreach($user['UserInterest'] as $id) {
            if($i = $this->Interest->findById($id['interest_id'])){
                $interestNames[$i['Interest']['id']] = $i['Interest']['name'];
            }
        }

        $this->set(array(
            'interests' => $interests,
            'selected' => $interestNames,
            'userToView' => $user
            )
        );
	}

    public function view($username = null) {

        if(!$userToView = $this->Profile->User->findByUsername($username)){
            if(!$userToView = $this->Profile->User->findById($username)){
                throw new NotFoundException(__('Invalid user'));
            }
        }

        $user = $this->Auth->user();

        if($username === $user['User']['username']){
            $this->redirect(array('controller' => 'profiles', 'action' => 'index'));
        }

        $interestNames = array();
        if(!empty($userToView['UserInterest'])){
            foreach($userToView['UserInterest'] as $interestId){
                $interest = $this->Interest->findById($interestId['interest_id']);
                $interestNames[] = $interest['Interest']['name'];
            }
        }

        $this->set(array(
            'userToView' => $userToView,
            'interestNames' => $interestNames
            )
        );
    }

}