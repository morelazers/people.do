<?php
class IdeasController extends AppController 
{
    public $helpers = array('Html', 'Form', 'Session', 'Js');
    public $components = array('Session', 'RequestHandler');
    public $uses = array('Interest', 'Idea');
    
    public function index()
    {
        $this->set('ideas', $this->Idea->find('all', array('order' => array('Idea.upvotes' => 'DESC'))));
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
        
        $ideaUpvotes = $this->Idea->IdeaUpvote->find('all', array(
            'conditions' => array('idea_id' => $id)));
        $commentUpvotes = $this->Idea->Comment->CommentUpvote->find('all', array(
            'conditions' => array('CommentUpvote.user_id' => $uid)));
        
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
            $uid = $this->request->data['uid'];
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
    
    public function add() 
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->user();
            $this->request->data['Idea']['user_id'] = $user['User']['id'];
            $this->request->data['Idea']['shared_by_name'] = $user['User']['display_name'];
            $this->Idea->create();
                 
            if ($this->Idea->save($this->request->data)) {
                $ideaId = $this->Idea->getLastInsertId();
                
                $ideaInterest['idea_id'] = $ideaId;

                if(!empty($this->request->data['Interest']['id'])){
                    foreach($this->request->data['Interest']['id'] as $id){
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