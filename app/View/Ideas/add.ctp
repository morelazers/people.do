<div id="share-page" class="col-lg-10 text-left scrollable">
  <div class="top-spacer">
      
  </div>
  <h2>Tell the world about your idea!</h2>
  <div class="page-description">
      
  </div>
  
  <br />
  <div id="ErrorMessage">
  </div>
  
  <div class="share-idea-form pull-left">
    <?php
        echo $this->Form->create('Idea');
    ?>
    
    <div class="form-group">
    <?php echo $this->Form->input('name', array('error' => false, 'class' => 'form-control')); ?>
    </div>
    <div class="form-group">
    <?php echo $this->Form->input('description', array('rows' => '7','error' => false, 'class' => 'form-control')); ?>
    </div>

    <div class="form-group">    

    <?php
      echo $this->element('interestBox', array(
          'interests' => $interests,
          'selected' => null,
          'placeholder' => 'Start typing to see existing interests!'
          )
      );
    
    ?>

    </div>

    <div class="form-group">

    <?php
        $requireLoginClass = "";
        if(!isset($user)){
          $requireLoginClass = "login-required";
        }
        echo $this->Form->end(array(
            'id' => 'SubmitIdea',
            'label' => 'Share!',
            'class' => $requireLoginClass . " btn btn-default submit-idea"
            )
        );
    ?>

  </div>

  </div>
  <span class="share-idea-tips pull-right text-right">
  </span>
</div>
