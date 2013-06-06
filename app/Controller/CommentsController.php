<?php
class CommentsController extends AppController {
    
    public $components = array('RequestHandler');
    
    public function upvote() {
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $id = $this->request->data['id'];
            $this->Comment->updateAll(array('Comment.upvotes' =>'Comment.upvotes + 1'), array('Comment.id' => $id));
            $this->Comment->CommentUpvote->create();
            $data = array(
                'comment_id' => $id,
                'user_id' => $this->Auth->user('id')
                );
            $this->Comment->CommentUpvote->save($data);
            $upvotes = $this->request->data['upvotes'];
            $newUpvoteNumber = $upvotes + 1;
            echo $newUpvoteNumber;
        }
    }
    
}
?>