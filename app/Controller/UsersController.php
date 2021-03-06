<?php
class UsersController extends AppController {
    
    public $uses = array('User', 'IdeaInterest', 'Idea');
    
    public function getCurrentUserId(){
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->autoRender = false;
            $user = $this->Auth->user();
            $uid = $user['User']['id'];
            echo json_encode(array('id' => $uid));
        }
    }
    
    public function ajaxOpauth(){
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->autoRender = false;
            $this->Session->write('User.ajaxOpauth', true);
            echo true;
        }
    }
    
    public function opauth_complete(){

        //debug($this->data);
        
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
        
        if(!$this->Session->read('User.ajaxOpauth')) {
            $this->Session->write('User.ajaxOpauth', false);
            $this->redirect($this->Auth->redirect());
        }
        
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
    
    public function ajax_login() {
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->autoRender = false;
            $this->Auth->authenticate = array('Form');
            
            $this->request->data['User']['username'] = $this->request->data['username'];
            $this->request->data['User']['password'] = $this->request->data['password'];
            
            if($this->Auth->login()){
                $user = $this->User->findByUsername($this->request->data['User']['username']);
                $this->Auth->login($user);
                echo json_encode(array('valid' => true));
            } else {
                echo json_encode(array('valid' => false));
            }
        }
    }
    
    public function ajax_register() {
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->autoRender = false;
            $this->User->create();
            
            $this->request->data['User']['username'] = $this->request->data['username'];
            $this->request->data['User']['password'] = $this->request->data['password'];
            if($this->request->data['email']){
                $this->request->data['User']['email_address'] = $this->request->data['email'];
            }
            
            $this->request->data['User']['display_name'] = $this->request->data['User']['username'];
            if($this->User->save($this->request->data)){
                $id = $this->User->getLastInsertId();
                $user = $this->User->findById($id);
                $this->Auth->login($user);
                echo json_encode(array('valid' => true));
            } else {
                echo json_encode(array('valid' => false));
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

/*    public function index($username = null) {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate()); 
    }*/

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
                //debug($this->request->data);
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
        
        /*$this->paginate = array(
            'limit' => 20
        );*/
    
        //$ideas = $this->paginate('Idea');
        
        if(!$user){
            $ideasToDisplay = $this->Idea->find('all', array('order' => array('Idea.upvotes' => 'DESC')));
            $this->set(array(
                'ideas' => $ideasToDisplay
                    )
                );
            return;
        }
        
        // Find the idea interests that have the same ids as the user interests
        
        // Count the number of times a single idea id comes up
        
        // Display the list in descending order
        
        $ideaInterests = array();
        
        // Find the ideas with matching interests
        foreach($user['UserInterest'] as $interest){
            $ideaInterests[] = $this->IdeaInterest->find(
                'all', 
                array(
                'conditions' => array(
                    'IdeaInterest.interest_id' => $interest['interest_id']
                    )
                )
            );
        }
        
        $ideas = array();
        
        // Count the number of matches in each idea
        foreach ($ideaInterests as $match) {
            foreach($match as $interest) {
                if($interest['IdeaInterest']['idea_id']){
                    if(isset($ideas[$interest['IdeaInterest']['idea_id']])){
                        // Add one to the matching interest count of this idea
                        $ideas[$interest['IdeaInterest']['idea_id']]++;
                    } else {
                        // If it's the first time we've seen this ID, add it to the array with value 1
                        $ideas[$interest['IdeaInterest']['idea_id']] = 1;
                    }
                }
            }
        }
        
        //debug($ideas);
        
        arsort($ideas);
        
        //debug($ideas);
        
        $ids = array_keys($ideas);
        
        //debug($ids);
        
        //$ideas = array_flip($ideas);
        
        //debug($ideas);
        
        $this->paginate = array(
            'limit' => 20,
            'conditions' => array(
                'Idea.id' => $ids
            )
        );
    
        $ideasToDisplay = $this->paginate('Idea');
        
        /*$ideasToDisplay = $this->Idea->find(
        'all',
        array(
            'conditions' => array(
                'Idea.id' => $ids
                )
            )
        );*/
        
        $this->set(array(
            'ideas' => $ideasToDisplay,
            'user' => $user
            )
        );
        
    }
}
?>