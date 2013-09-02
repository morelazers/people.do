<?php
class ProfilesController extends AppController{
    
    public $components = array('Session', 'RequestHandler');
    public $uses = array('Interest', 'User', 'Profile');
	
	public function index(){

		// Get the currently logged in user
		$user = $this->Auth->user();

        if (!$user) {
            $this->Session->setFlash('Please login');
            $this->redirect(array('controller' => 'users', 'action' =>'login'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

        	// Align the being-edited profile with the one in the database
            $profile['Profile']['id'] = $user['Profile']['id'];
            $profile['Profile']['user_id'] = $user['User']['id'];
            
            $userInterest['user_id'] = $user['User']['id'];
            
            $this->Profile->User->UserInterest->deleteAll(array('UserInterest.user_id' => $userInterest['user_id']));
            
            if(!empty($this->request->data['Interest']['id'])){
                foreach($this->request->data['Interest']['id'] as $id){
                    if(!is_numeric($id)){
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
                $this->Session->setFlash('Your profile has been updated.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Unable to update your profile.');
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
            'selected' => $interestNames
            )
        );
	}
    
    public function view($id = null) {
        if(!$userToView = $this->Profile->User->findById($id)){
            throw new NotFoundException(__('Invalid user'));
        }
        
        $user = $this->Auth->user();
        
        if($id === $user['User']['id']){
            $this->redirect(array('controller' => 'profiles', 'action' => 'index'));
        }
        
        $this->set(array(
            'userToView' => $userToView
            )
        );
    }
    
}
?>