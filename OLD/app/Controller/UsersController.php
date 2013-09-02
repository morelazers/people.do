<?php
class UsersController extends AppController {
    
    public $uses = array('User', 'IdeaInterest', 'Idea');
    
    public function opauth_complete(){
        
        if(isset($this->data['error'])){
            die;
        }
        
        if($this->data['auth']['provider'] === 'Google'){
            $googleUser = $this->User->GoogleUser->findByGoogleId($this->data['auth']['raw']['id']);
            if(!$googleUser){
                $this->User->GoogleUser->addUser($this->data);
            }
            $googleUser = $this->User->GoogleUser->findByGoogleId($this->data['auth']['raw']['id']);
            $user = $this->User->findById($googleUser['User']['id']);
            $this->Auth->login($user);
        }
        elseif($this->data['auth']['provider'] === 'Facebook'){
            $facebookUser = $this->User->FacebookUser->findByFacebookLink($this->data['auth']['raw']['link']);
            if(!$facebookUser){
                $this->User->FacebookUser->addUser($this->data);
                $facebookUser = $this->User->FacebookUser->findByFacebookLink($this->data['auth']['raw']['link']);
            }
            $user = $this->User->findById($facebookUser['User']['id']);
            $this->Auth->login($user);
        }
        $this->redirect($this->Auth->redirect());
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add'); // Letting users register themselves
    }
    
    public function login() {
        $this->Auth->authenticate = array('Form');
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $user = $this->User->findByUsername($this->request->data['User']['username']);
                $this->Auth->login($user);
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function index($username = null) {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate()); 
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['display_name'] = $this->request->data['User']['username'];
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }
    
    public function checkExistence() {
        if($this->request->is('ajax')) {
            if(!isset($this->request->data['username'])){
                exit;
            }
            $this->layout = 'ajax';
            $this->autoRender = false;
            $user = $this->User->findByUsername($this->request->data['username']);
            if(!$user){
                echo json_encode(array('exists' => false));
            } else {
                echo json_encode(array('exists' => true));
            }
        }
    }
    
    public function think() {
        $user = $this->Auth->user();
        
        // Find the IdeaInterests that have the same InterestIds as the UserInterests
        
        // Count the number of times a single IdeaId comes up
        
        // Display the list in descending order
        
        $IdeaInterests = array();
        
        foreach($user['UserInterest'] as $interest){
            $IdeaInterests[] = $this->IdeaInterest->find(
                'all', 
                array(
                'conditions' => array(
                    'IdeaInterest.interest_id' => $interest['interest_id']
                    )
                )
            );
        }
        
        $ideas = array();
        foreach ($IdeaInterests as $match) {
            foreach($match as $interest) {
                if($interest['IdeaInterest']['idea_id']){
                    if(isset($ideas[$interest['IdeaInterest']['idea_id']])){
                        $ideas[$interest['IdeaInterest']['idea_id']]++;
                    } else {
                        $ideas[$interest['IdeaInterest']['idea_id']] = 1;
                    }
                }
            }
        }
        
        arsort($ideas);
        
        $ideas = array_flip($ideas);
        
        $ideasToDisplay = $this->Idea->find(
        'all',
        array(
            'conditions' => array(
                'Idea.id' => $ideas
                )
            )
        );
        
        $this->set(array(
            'ideas' => $ideasToDisplay
            )
        );
        
    }
}
?>