<?php $this->start('topbar'); ?>
<h1>
<?php echo $userToView['User']['display_name']; ?>
</h1>
<?php
echo $this->Html->link('Message '.$userToView['User']['display_name'], array('controller' => 'messages', 'action' => 'send', $userToView['User']['id']), array('id' => 'MessageUser'));
?>
<?php echo $this->end(); ?>

<h3 class="profileHeading">About <?php echo $userToView['User']['display_name']; ?>:</h3>
<p>
<php
if(isset($userToView['Profile']['about_me'])){
    echo $userToView['Profile']['about_me']; 
} else {
    echo "This user has yet to write anything about themselves, if you're sitting next to them, give them a nudge.";
}
?>
</p>

<h3 class="profileHeading"><?php echo $userToView['User']['display_name']; ?>'s Interests:</h3>
<p>
<?php 
foreach($interestNames as $name){
    echo $name.', ';
}
?>
</p>