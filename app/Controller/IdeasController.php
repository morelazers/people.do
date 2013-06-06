<?php
class IdeasController extends AppController 
{
    public $helpers = array('Html', 'Form', 'Session', 'Js');
    public $components = array('Session', 'RequestHandler');
    
    public function index()
    {
        $this->set('ideas', $this->Idea->find('all'));
    }
    
    public function view($id = null) 
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid idea'));
        }
        
        if($this->request->is('post')) {
            $this->request->data['Comment']['user_id'] = $this->Auth->user['id'];
            $this->request->data['Comment']['idea_id'] = $id;
            $this->request->data['Comment']['content'] = $this->request->data['Comment']['comment'];
            $this->Idea->Comment->create();
            if($this->Idea->Comment->save($this->request->data)) {
                $this->Session->setFlash('Comment posted!');
            }
        }
        
        $idea = $this->Idea->findById($id);
        
        if (!$idea) {
            throw new NotFoundException(__('Invalid idea'));
        }
        
        $data = array(
            'idea' => $idea
            );
        
        $this->set($data);
    }
    
    public function upvote() {
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $id = $this->request->data['id'];
            $this->Idea->updateAll(array('Idea.upvotes' =>'Idea.upvotes + 1'), array('Idea.id' => $id));
            $this->Idea->IdeaUpvote->create();
            $data = array(
                'idea_id' => $id,
                'user_id' => $this->Auth->user['id']
                );
            $this->Idea->IdeaUpvote->save($data);
            $upvotes = $this->request->data['upvotes'];
            $newUpvoteNumber = $upvotes + 1;
            echo $newUpvoteNumber;
        }
    }
    
    public function add() 
    {
        if ($this->request->is('post')) {
            $this->request->data['Idea']['user_id'] = $this->Auth->user['id'];
            $this->Idea->create();
            if ($this->Idea->save($this->request->data)) {
                $this->Session->setFlash('Your idea has been posted.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Unable to add your idea.');
            }
        }
    }
    
    public function isAuthorized($user) 
    {
        // All registered users can add posts
        if ($this->action === 'add') {
            return true;
        }
    
        // The owner of a post can edit and delete it
        if (in_array($this->action, array('edit', 'delete'))) {
            $ideaID = $this->request->params['pass'][0];
            if ($this->Post->isOwnedBy($ideaID, $user['id'])) {
                return true;
            }
        }
    
        return parent::isAuthorized($user);
    }
    
}
?>