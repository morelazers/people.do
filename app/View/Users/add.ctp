<!-- app/View/Users/add.ctp -->
<?php echo $this->Html->script('ajax_checkNewUsernameIsValid'); ?>
<?php echo $this->Html->script('ajax_checkPasswordsMatch'); ?>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php 
        echo $this->Form->input('username');
        ?>
        <div id="UsernameValidMessage"></div>
        <?php
        echo $this->Form->input('password');
        echo $this->Form->input('repeat_password', array(
                                    'type' => 'password'
                                    ));
        ?>
        <div id="PasswordMatchMessage"></div>
        <?php
        echo $this->Form->input('email');
        ?>
    </fieldset>
<?php 
echo $this->Form->end(array(
                            'label' => 'Sign Up',
                            'id' => 'RegisterButton'
                            ));
?>
</div>