<!-- File: /app/View/Ideas/add.ctp -->

<?php echo $this->Html->script('ajax_loginAndRefreshPage.js'); ?>

<?php echo $this->start('topbar'); ?>
<h1>Share your idea!</h1>
<?php echo $this->end(); ?>
<br />
<div id="ErrorMessage">
<?php echo $this->Session->flash(); ?>
</div>
<?php
    echo $this->Form->create('Idea');
    echo $this->Form->error('name');
    echo $this->Form->input('name', array('error' => false));
    echo $this->Form->error('description');
    echo $this->Form->input('description', array('rows' => '3','error' => false));
    
    echo $this->element('interestBox', array(
        'interests' => $interests,
        'selected' => null,
        'placeholder' => 'Tag your idea with some interests!'
        )
    );
?>
<?php
    echo $this->Form->end(array(
        'id' => 'SubmitIdea',
        'label' => 'Share!'
        )
    );
?>

