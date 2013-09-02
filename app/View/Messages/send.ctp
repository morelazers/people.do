<?php $this->start('topbar'); ?>
<h1>Send a message to <?php echo $toUser['User']['display_name']; ?></h1>
<?php $this->end(); ?>

<?php
echo $this->Form->create('Message');
?>

<?php
echo $this->Form->input('subject');
echo $this->Form->input('content', array('rows' => '3'));
echo $this->Form->end(array('label' => 'Send Message', 'id' => 'SendButton', 'class' => 'loginRequired'));
?>