<?php
class CommentsController extends AppController {
    
    public $components = array('RequestHandler');
    public $uses = array('Comment', 'Idea', 'User');
    
    /**
     * Upvote a comment via an AJAX POST request
     * No check for a logged in user, will spit an error if not (but shouldn't be able to be called)
     * @param id - the comment id
     */
    public function upvote() {
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $id = $this->request->data['id'];
            $user = $this->Auth->user();
            $uid = $user['User']['id'];
            
            /* This logic could be in model */
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

    /**
     * Post a comment on an idea, possibly replying to another comment via AJAX POST request
     * @param ideaId - the id of the idea to post the comment to
     * @param parentId - the id of the parent comment (-1 if none)
     * @param content - the contents of the reply to be posted
     *
     * @return content - the contents of the reply saved
     * @return newId - the id of the new comment
     * @return comment - the HTML of the new comment element (should generate this in JS really)
     * @returntype JSON Object
     *
     */
    public function reply(){
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            
            $child = true;
            $user = $this->Auth->user();
            
            $ideaId = $this->request->data['ideaId'];
            if($this->request->data['parentId'] !== '-1'){
                $parentId = $this->request->data['parentId'];
            } else {
                $parentId = null;
                $child = false;
            }
            $uid = $user['User']['id'];
            $content = $this->request->data['content'];
            $this->Comment->create();
            $data = array(
                'idea_id' => $ideaId,
                'parent_id' => $parentId,
                'user_id' => $uid,
                'content' => $content
            );
            
            $this->Comment->save($data);
            
            $newId = $this->Comment->getLastInsertId();
            $comment = $this->Comment->findById($newId);
            
            
            $data = array(
                'Comment' => array(
                    'id' => $this->Comment->id,
                    'content' => $content,
                    'upvotes' => 1,
                    'UserId' => $user['User']['id']
                ),
            );
            
            // AJAX request so refresh the user's session manually
            $user = $this->User->findById($user['User']['id']);
            $this->Auth->login($user);
                
            $view = new View($this, false);
            
            $view->set(array(
                'user' => $user,
                'comment' => $comment,
                'newComment' => true,
                'child' => $child
                )
            );
            
            $newId = $this->Comment->id;
            
            $view->viewPath = 'Elements';
            $view_output = $view->render('comment');
            echo json_encode(array('content' => $content, 'newCommentId' => $newId, 'comment' => $view_output));
            
            if($parentId !== null){
                $this->Comment->notifyPoster($uid, $data, $parentId, $newId);
            }
            $idea = $this->Idea->findById($ideaId);
            $this->Idea->notifyPoster($uid, $data, $idea['Idea']['user_id'], $newId);
        }
    }
    
}
?>