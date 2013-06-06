<?php
// app/Controller/UsersController.php
App::import('Vendor', 'OAuth/OAuthClient');
class UsersController extends AppController {

    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Auth->allow('add'); // Letting users register themselves
    }
    
    public function login() 
    {
        $this->Auth->authenticate = array('Form');
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
    }

    public function logout() 
    {
        $this->redirect($this->Auth->logout());
    }

    public function index() 
    {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
        //pr($this->Auth->user());
    }

    public function view($id = null) 
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() 
    {
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

    public function edit($id = null) 
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) 
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function checkExistence() {
        //echo json_encode(array('exists' => true));
        if($this->request->is('ajax')) {
            //echo json_encode(array('exists' => true));
            if(!isset($this->request->data['username'])){
                exit;
            }
            $this->layout = 'ajax';
            $this->autoRender = false;
            $user = $this->User->findByUsername($this->request->data['username']);
            //pr($user);
            if(!$user){
                echo json_encode(array('exists' => false));
            } else {
                echo json_encode(array('exists' => true));
            }
        }
    }
}
?>