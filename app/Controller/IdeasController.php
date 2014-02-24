<?php
class IdeasController extends AppController 
{
    public $helpers = array('Html', 'Form', 'Session', 'Js');
    public $components = array('Session', 'RequestHandler');
    public $uses = array('Interest', 'Idea', 'IdeaUpvote', 'CommentUpvote', 'Comment');
    
    public function index()
    {
        $ideas = $this->Idea->find('all', array('order' => array('Idea.upvotes' => 'DESC')));
        $this->set(array('ideas' => $ideas));
    }
    
    public function ajaxview(){
      if($this->request->is('ajax')){
        $this->layout = 'ajax';
        $this->autoRender = false;
     
        $user = $this->Auth->user();
        $uid = $user['User']['id'];
        
        $id = $this->request->data['ideaId'];
        $idea = $this->Idea->findById($id);
        
        //debug($id);
        
        if(!$idea){
          $this->Idea->find('first', array('order' => array('Idea.upvotes' => 'DESC'))); 
        }
        
        $ideaUpvotes = $this->IdeaUpvote->find('list', array(
            'fields' => array('IdeaUpvote.idea_id'),
            'conditions' => array(
              'IdeaUpvote.idea_id' => $id,
              'IdeaUpvote.user_id' => $uid
            ),
            'recursive' => 0
          )
        );
        
        $commentUpvotes = $this->Comment->CommentUpvote->find('list', array(
            'fields' => array('CommentUpvote.comment_id'),
            'conditions' => array(
              'CommentUpvote.user_id' => $uid,
              'Comment.idea_id' => $id
            ),
            'recursive' => 0
          )
        );
        
        //debug($ideaUpvotes);
        //debug($commentUpvotes);
          
        $this->Idea->unbindModel(
            array('hasMany' => array('Comment'))
        );
        
        $comments = $this->Idea->Comment->find(
          'threaded', array(
            'conditions' => array(
              'Comment.idea_id' => $id
            ),
            'order' => array(
              'Comment.upvotes' => 'desc'  
            ),
            'recursive' => 0
          )
        );
        
        $tosend = compact('idea', 'ideaUpvotes', 'commentUpvotes', 'comments', 'user');
        
        /*$data = array(
          'idea' => $idea,
          'ideaUpvotes' => $ideaUpvotes,
          'commentUpvotes' => $commentUpvotes,
          'comments' => $comments,
          'user' => $user
        );*/
        
        $view = new View($this, false);
        //$content = "";
        $content = $view->element('ideaDescription', $tosend);
        
        echo json_encode(array('markup' => $content));
      
      }
      
    }
    
    public function view($id = null) 
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid idea'));
        }
        
        $user = $this->Auth->user();
        
        $uid = $user['User']['id'];
        
        $idea = $this->Idea->findById($id);
        
        if($this->request->is('post')) {
            $this->request->data['Comment']['user_id'] = $uid;
            $this->request->data['Comment']['idea_id'] = $id;
            
            $this->Idea->Comment->create();
            if($this->Idea->Comment->save($this->request->data)) {
                $newId = $this->Idea->Comment->getLastInsertId();
            }
            if($idea['Idea']['user_id'] !== $uid) {
                $this->Idea->notifyPoster($uid, $this->request->data, $idea['Idea']['user_id'], $newId);
            }
            $this->redirect(array('action' => 'view', $id));
        }
        
        $ideaUpvotes = $this->Idea->IdeaUpvote->find('list', array(
            'fields' => array('IdeaUpvote.idea_id'),
            'conditions' => array('idea_id' => $id)));
        $commentUpvotes = $this->Idea->Comment->CommentUpvote->find('list', array(
            'fields' => array('CommentUpvote.comment_id'),
            'conditions' => array('CommentUpvote.user_id' => $uid)));
        
        debug($ideaUpvotes);
        
        if (!$idea) {
            throw new NotFoundException(__('Invalid idea'));
        }
        
        $this->Idea->unbindModel(
            array('hasMany' => array('Comment'))
        );
        
        $comments = $this->Idea->Comment->find(
            'threaded', array(
                'conditions' => array(
                    'Comment.idea_id' => $id
                ),
                'order' => array(
                    'Comment.upvotes' => 'desc'  
                )
            )
        );
        
        $data = array(
            'idea' => $idea,
            'ideaUpvotes' => $ideaUpvotes,
            'commentUpvotes' => $commentUpvotes,
            'comments' => $comments,
            'user' => $user
        );

        $this->set($data);
    }
    
    public function upvote() {
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $id = $this->request->data['id'];
            $user = $this->Auth->user();
            $uid = $user['User']['id'];
            if($vote = $this->Idea->IdeaUpvote->findByIdeaIdAndUserId($id, $uid)){
                $this->Idea->IdeaUpvote->delete($vote['IdeaUpvote']['id']);
                $this->Idea->updateAll(array('Idea.upvotes' =>'Idea.upvotes - 1'), array('Idea.id' => $id));
            } else {
                $this->Idea->updateAll(array('Idea.upvotes' =>'Idea.upvotes + 1'), array('Idea.id' => $id));
                $this->Idea->IdeaUpvote->create();
                $data = array(
                    'idea_id' => $id,
                    'user_id' => $uid
                    );
                $this->Idea->IdeaUpvote->save($data);
            }
            $user = $this->Idea->User->findById($this->Auth->user['id']);
            $this->Auth->login($user);
        }
    }
    
    public function ajaxShare(){
     
      $this->layout = 'ajax';
      $this->autoRender = false;
     
      if($this->request->is('ajax')){
        //debug($this->request->data);
        $user = $this->Auth->user();
        $this->request->data['Idea']['user_id'] = $user['User']['id'];
        $this->request->data['Idea']['shared_by_name'] = $user['User']['display_name'];
        $this->Idea->create();
        if ($this->Idea->save($this->request->data)) {
          $ideaId = $this->Idea->getLastInsertId();
          $this->addInterests($this->request->data, $ideaId, $user);
          echo json_encode(array('newid' => $this->Idea->id));
          //$this->redirect(array('action' => 'view', $ideaId));
        } else {
          echo json_encode(array('error' => 'Unable to share'));
        }
      }
      
    }
    
    public function add() 
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->user();
            $this->request->data['Idea']['user_id'] = $user['User']['id'];
            $this->request->data['Idea']['shared_by_name'] = $user['User']['display_name'];
            $this->Idea->create();
                 
            if ($this->Idea->save($this->request->data)) {
                $ideaId = $this->Idea->getLastInsertId();
                
                $this->addInterests($this->request->data, $ideaId, $user);
                
                
                $this->redirect(array('action' => 'view', $ideaId));
            } else {
                $this->Session->setFlash('Unable to add your idea.');
            }
        }
        $interests = $this->Interest->find('all');
        $this->set(array(
            'interests' => $interests
            )
        );
    }
    
    public function edit($id = null){
    
        $user = $this->Auth->user();
    
        if($this->isAuthorised($user)){
            
            if (!$id) {
                throw new NotFoundException(__('Invalid idea'));
            }
        
            $idea = $this->Idea->findById($id);
            if (!$idea) {
                throw new NotFoundException(__('Invalid idea'));
            }
        
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->Idea->id = $id;
                if ($this->Idea->save($this->request->data)) {
                    $this->addInterests($this->request->data, $id, $user);
                    $this->Session->setFlash(__('Your idea has been updated.'));
                    return $this->redirect(array('action' => 'view', $id));
                }
                $this->Session->setFlash(__('Unable to update your idea.'));
            }
        
            if (!$this->request->data) {
                $this->request->data = $idea;
            }
            
            $interestNames = array();
            foreach($idea['IdeaInterest'] as $id) {
                if($i = $this->Interest->findById($id['interest_id'])){
                    $interestNames[$i['Interest']['id']] = $i['Interest']['name'];
                }
            }
            
            $interests = $this->Interest->find('all');
            
            $this->set(array(
                'interests' => $interests,
                'selectedInterests' => $interestNames
                )
            );
        }
        
    }

    public function addInterests($data, $ideaId, $user){
        
        $ideaInterest['idea_id'] = $ideaId;

        if(!empty($data['Interest']['id'])){
            foreach($data['Interest']['id'] as $id){
                if(!is_numeric($id)){
                    $this->Interest->saveNewInterest($id, $user['User']['id']);
                    $id = $this->Interest->getLastInsertId();
                }
                if(!$this->Idea->IdeaInterest->findByIdeaIdAndInterestId($ideaId, $id)) {
                    $ideaInterest['interest_id'] = $id;
                    $this->Idea->IdeaInterest->create();
                    $this->Idea->IdeaInterest->save($ideaInterest);
                }
            }
        }
        
    }

    public function isAuthorised($user) 
    {
        // All registered users can add posts
        if ($this->action === 'add') {
            return true;
        }
    
        // The owner of a post can edit and delete it
        if (in_array($this->action, array('edit', 'delete'))) {
            $ideaID = $this->request->params['pass'][0];
            if ($this->Idea->isOwnedBy($ideaID, $user['User']['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }
    
}
?>