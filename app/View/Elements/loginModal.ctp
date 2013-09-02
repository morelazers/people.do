<div id="LoginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Login!</h3>
    </div>
    <div class="modal-body">
        <div id="ModalLoginForm" class="span4">
            <?php
                echo $this->Form->create('User', array('id' => 'UserLoginForm')); 
                echo $this->Form->input('username');
                echo $this->Form->input('password', array('id' => 'LoginPassword'));
                echo $this->Form->submit('Login', array('type' => 'submit', 'class' => 'loginButton', 'id' => 'ModalLoginSubmit'));
                echo $this->Form->end();
            ?>
            <br />
            <div id="ModalLoginMessage">
            </div>
        </div>
        <div id="ModalRegisterForm" class="span4">
            <p>Or if you don't have an account yet, register; it only takes a second!</p>
            <?php
                echo $this->Form->create('User', array('id' => 'UserAddForm')); 
                echo $this->Form->input('username', array('id' => 'RegisterUsername'));
            ?>
            <div id="UsernameValidMessage"></div>
            <?php
                echo $this->Form->input('password');
                echo $this->Form->input('repeat_password', array('type' => 'password', 'id' => 'UserRepeatPassword'));
                echo $this->Form->input('email', array('label' => 'Email address (optional)'));
            ?>
            <div id="PasswordMatchMessage">
            </div>
            <?php
                echo $this->Form->submit('Register', array('type' => 'submit', 'class' => 'registerButton', 'id' => 'RegisterButton'));
                echo $this->Form->end();
            ?>
            <div id="ModalRegisterMessage">
            </div>
        </div>
    </div>
    
    
    <div id="OtherLogin">
        Alternatively, log in with
        <?php
            echo $this->Form->button('', array('id' => 'FacebookModalButton', 'class' => 'facebookButton', 'type' => 'button'));
        ?>
        or 
        <?php
            echo $this->Form->button('Google', array('id' => 'GoogleModalButton', 'class' => 'googleButton', 'type' => 'button'));
        ?>!
        <br />
        (You might have to enable popups, sorry!)
        <div id="OpAuthMessage">
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    </div>
</div>

<script>
$('#CommentForm').submit(function(event){
    if(!userIsLoggedIn){
        event.preventDefault();
        window.commentSubmit = true;
        $('#LoginModal').modal('show');
    }
});

$(".loginRequired").click(function(event){
    if(!userIsLoggedIn){
        $('#LoginModal').modal('show');
    }
});

$("#SendButton").click(function(event){
    if(!userIsLoggedIn){
        event.preventDefault();
        window.messageSend = true;
        $('#LoginModal').modal('show');
    }
});

$("#SubmitIdea").click(function(event){
    if(!userIsLoggedIn){
        event.preventDefault();
        $('#LoginModal').modal('show');
    }
});
</script>

<?php echo $this->Html->script('ajax_checkPasswordsMatch.js'); ?>