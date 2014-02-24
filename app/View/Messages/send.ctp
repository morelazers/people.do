

<div id="message-page" class="col-lg-10 text-left scrollable">

<div class="top-spacer">
</div>

<h2>Send a message to <?php echo $toUser['User']['display_name']; ?></h2>
  <div class="page-description">
      I'm sure they would love to hear from you!
  </div>
  
  
  <div class="message-send-form">
  
    <?php
    echo $this->Form->create('Message');
    ?>
    
    <div class="form-group">
    <?php
    echo $this->Form->input('subject', array('class' => 'form-control'));
    ?>
    </div>
    
    <div class="form-group">
    <?php
    echo $this->Form->input('content', array('rows' => '7', 'class' => 'form-control'));
    ?>
    </div>
    
    <?php
    echo $this->Form->end(array('label' => 'Send Message', 'id' => 'SendButton', 'class' => 'btn btn-default'));
    ?>
  
  </div>
</div>