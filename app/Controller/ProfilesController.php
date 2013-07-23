<?php
class ProfilesController extends AppController{
	
	public function index(){

		// Get the currently logged in user
		$loggedIn = $this->Auth->user();

        if (!$loggedIn) {
            $this->Session->setFlash('Please login');
            $this->redirect(array('controller' => 'users', 'action' =>'login'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

        	// Align the being-edited profile with the one in the database
            $this->request->data['Profile']['id'] = $loggedIn['Profile']['id'];
            if ($this->Profile->save($this->request->data)) {
                $this->Session->setFlash('Your profile has been updated.');

                // Log the user in again to show the changes immediately
                $user = $this->Profile->User->findById($loggedIn['User']['id']);
                $this->Auth->login($user);
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Unable to update your profile.');
            }
        }
	}
}
?>