<?php
class CommentsController extends AppController {
    
    public $components = array('RequestHandler');
    
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
            $parentId = $this->request->data['parentId'];
            $uid = $this->request->data['uid'];
            $content = $this->request->data['content'];
            $this->Comment->create();
            $data = array(
                'idea_id' => $ideaId,
                'parent_comment_id' => $parentId,
                'user_id' => $uid,
                'content' => $content
                );
            $this->Comment->save($data);
            $user = $this->Auth->user();
            $comment = array(
                'id' => $this->Comment->id,
                'content' => $content,
                'upvotes' => 1
                );
            $this->set(array(
                'user' => $user,
                'comment' => $comment
                ));
                
            //$this->autoRender = false;
            $view = new View($this, false);
            $view->set(array(
                'user' => $user,
                'comment' => $comment
                ));
            $view->viewPath = 'Elements';
            $view_output = $view->render('comment');
                
                
            
            /*$variable = $this->render('/Elements/comment');*/
            echo json_encode(array('content' => $content, 'newCommentId' => $this->Comment->id, 'comment' => $view_output));
        }
    }
    
}
?>