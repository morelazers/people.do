<div id="messages-page" class="col-lg-10 text-left scrollable">

  <div class="top-spacer">
  </div>

  <h2>Messages</h2>
  <div class="pageDescription">
      Here are the messages that people have sent you.
  </div>
  
  <div class="messages-container">
      <?php foreach($messages as $message): ?>
      <p>
          <div class="message">
              <div class="message-info">
                <div class="from-id">
                  <?php echo $message['Sender']['id']; ?>
                </div>
                <div class="parent-id">
                  <?php echo $message['Message']['comment_id']; ?>
                </div>
              </div>
                <a href="/user/<?php echo $message['Sender']['display_name']; ?>"><?php echo $message['Sender']['display_name']; ?></a>
              <br />
              Sent: <?php echo $this->Time->format("F jS, Y H:i", $message['Message']['created']); ?>
              <br />
              <span class="subject"><strong><?php echo $message['Message']['subject']; ?></strong></span>
              <br/>
              <?php echo $message['Message']['content']; ?>
              </br>
              <button class="btn btn-default btn-reply-to-message">Reply</button>
              
              
              
              <?php
                  //debug($message);
                  if($message['Comment']['id'] !== null){
                      ?>
                      <a href="/<?php echo $message['Comment']['idea_id']; ?>" class="btn-message-view-idea btn btn-default">Idea</a>
                      <?php
                  }
              ?>
          </div>
      </p>
      <?php endforeach; ?>
  </div>
</div>