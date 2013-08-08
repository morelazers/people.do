<?php echo $this->Html->script('ajax_replyToMessage.js'); ?>
<h1>Messages:</h1>
</br>
</br>
<?php foreach($messages as $message): ?>
<p>
    <span id="Subject<?php echo $message['Message']['id']; ?>"><b><?php echo $message['Message']['subject']; ?></b></span>
    <br/>
    <?php echo $message['Message']['content']; ?>
    </br>
    <?php
        echo $this->Form->button('Reply', array('type' => 'button', 'class' => 'replyToMessageButton', 'id' => 'ReplyToMessage'.$message['Message']['id']));
        if(!$parentId = $message['Message']['comment_id']){
            $parentId = 0;
        }
        $replyEventCode = 'showReplyBox('.$message['Message']['id'].', '.$user['User']['id'].', '.$message['Message']['from_user_id'].', '.$parentId.')';
        echo $this->Js->get('#ReplyToMessage'.$message['Message']['id'])->event('click', $replyEventCode, array('wrap' =>true));
    ?>
    
</p>
<?php endforeach; ?>