<?php
class CommentsController extends AppController {
    
    public $components = array('RequestHandler');
    public $uses = array('Comment', 'Idea', 'User');
    
    public function index(){
        /*$data = $this->Comment->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;');
        debug($data); die;*/
    }
    
    public function upvote() {
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $id = $this->request->data['id'];
            $uid = $this->request->data['uid'];
            if($vote = $this->Comment->CommentUpvote->findByCommentIdAndUserId($id, $uid)){
                $this->Comment->CommentUpvote->delete($vote['CommentUpvote']['id']);
                $this->Comment->UpdateAll(array('Comment.upvotes' => 'Comment.upvotes - 1'), array('Comment.id' => $id));
            } else {
                $this->Comment->updateAll(array('Comment.upvotes' =>'Comment.upvotes + 1'), array('Comment.id' => $id));
                $this->Comment->CommentUpvote->create();
                $data = array(
                    'comment_id' => $id,
                    'user_id' => $uid
                    );
                $this->Comment->CommentUpvote->save($data);
            }
        }
    }

    public function reply(){
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $ideaId = $this->request->data['ideaId'];
            if($this->request->data['parentId']){
                $parentId = $this->request->data['parentId'];
            } else {
                $parentId = null;
            }
            $uid = $this->request->data['uid'];
            $content = $this->request->data['content'];
            $this->Comment->create();
            $data = array(
                'idea_id' => $ideaId,
                'parent_id' => $parentId,
                'user_id' => $uid,
                'content' => $content
            );
            
            $this->Comment->save($data);
            $user = $this->Auth->user();
            $newId = $this->Comment->getLastInsertId();
            $comment = $this->Comment->findById($newId);
            
            /*$comment = array(
                'Comment' => array(
                    'id' => $this->Comment->id,
                    'content' => $content,
                    'upvotes' => 1
                )
            );*/
            
            $user = $this->User->findById($user['User']['id']);
            $this->Auth->login($user);
                
            $view = new View($this, false);
            $view->set(array(
                'user' => $user,
                'comment' => $comment,
                'newComment' => true
                )
            );
            
            $newId = $this->Comment->id;
            
            $view->viewPath = 'Elements';
            $view_output = $view->render('comment');
            echo json_encode(array('content' => $content, 'newCommentId' => $newId, 'comment' => $view_output));
            
            if($parentId !== null){
                $this->Comment->notifyPoster($uid, $data, $parentId, $newId);
            } else {
                $idea = $this->Idea->findById($ideaId);
                $this->Idea->notifyPoster($uid, $data, $idea['Idea']['user_id'], $newId);
            }
            
        }
    }
    
}
?>