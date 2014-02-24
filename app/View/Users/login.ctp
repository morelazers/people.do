<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
    <?php echo $this->start('topbar'); ?>
        <h1>Please enter your username and password</h1>
        <?php echo $this->end(); ?>
        <br />
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
<br />
</div>