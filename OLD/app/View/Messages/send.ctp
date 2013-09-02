<h1>Send a message</h1>

<?php echo $this->Html->script('ajax_checkUserExists'); ?>

<?php
echo $this->Form->create('Message');
echo $this->Form->input('recipient');
?>

<div id="UsernameValidMessage"></div>

<?php
echo $this->Form->input('subject');
echo $this->Form->input('content', array('rows' => '3'));
echo $this->Form->end(array(
                        'label' => 'Send Message',
                        'id' => 'SendButton'
                        ));
?>