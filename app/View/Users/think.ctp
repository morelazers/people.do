<!-- File: /app/View/Users/think.ctp -->

<?php echo $this->start('topbar'); ?>

<h1>Think</h1>
<div class="pageDescription">
    This page uses your interests to find some ideas that you might be interested in!
    <br/>

<?php 
    if(!isset($user)){
?>
        We see you haven't yet logged in, to get the most out of this page you should 
        <?php
            echo $this->Html->link('login', '#LoginModal', array('data-toggle' => 'modal'));
        ?>
        and set a few interests in your profile!
<?php
    } else {
?>
        To get the most out of this page, tell us what you're interested in by editing your 
        <?php
            echo $this->Html->link('profile!', array('controller' => 'profiles', 'action' => 'index'));
        ?>
<?php
    }
?>
</div>
<?php echo $this->end(); ?>

<?php echo $this->element('ideaList', array('ideas' => $ideas)); ?>