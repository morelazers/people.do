<div id="LoginModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
  
  <div class="modal-dialog">
    <div class="modal-content">
    
    
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="LoginModalLabel">Login!</h4>
      </div>
      <div class="modal-body">
          <p class="modal-msg">Or if you don't have an account yet, register; it only takes a second!</p>
          <div class="modal-login-form pull-left">
              <?php
                  echo $this->Form->create('User', array('id' => 'UserLoginForm')); 
                  echo $this->Form->input('username', array('class' => 'form-control'));
                  echo $this->Form->input('password', array('id' => 'LoginPassword', 'class' => 'form-control'));
                  echo $this->Form->submit('Login', array('type' => 'submit', 'class' => 'loginButton form-control', 'id' => 'ModalLoginSubmit'));
                  echo $this->Form->end();
              ?>
              <br />
              <div id="ModalLoginMessage">
              </div>
          </div>
          <div class="modal-register-form pull-right">
              <?php
                  echo $this->Form->create('User', array('id' => 'UserAddForm')); 
                  echo $this->Form->input('username', array('id' => 'RegisterUsername', 'class' => 'form-control'));
              ?>
              <div id="UsernameValidMessage"></div>
              <?php
                  echo $this->Form->input('password', array('class' => 'form-control'));
                  echo $this->Form->input('repeat_password', array('type' => 'password', 'id' => 'UserRepeatPassword', 'class' => 'form-control'));
                  echo $this->Form->input('email', array('label' => 'Email address (optional)', 'class' => 'form-control'));
              ?>
              <div id="PasswordMatchMessage">
              </div>
              <?php
                  echo $this->Form->submit('Register', array('type' => 'submit', 'class' => 'registerButton form-control', 'id' => 'RegisterButton'));
                  echo $this->Form->end();
              ?>
              <div id="ModalRegisterMessage">
              </div>
          </div>
      </div>
      
      
      <div class="modal-other-login">
          Alternatively, log in with
          <a href="#" id="FacebookModalButton" class="facebookButton">
              <img src="/img/fbLoginButtonSmall.jpg"></img>
          </a>
          <?php
              //echo $this->Form->button('', array('id' => 'FacebookModalButton', 'class' => 'facebookButton', 'type' => 'button'));
          ?>
          or 
          <a href="#" id="GPlusModalButton" class="gPlusButton">
              <img src="/img/gPlusLoginButtonSmall.jpg"></img>
          </a>
          <?php
              //echo $this->Form->button('Google', array('id' => 'GoogleModalButton', 'class' => 'googleButton', 'type' => 'button'));
          ?>
          <br />
          (You might have to enable popups, sorry!)
          <div id="OpAuthMessage">
          </div>
      </div>
      <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
      </div>
    </div>
  </div>
</div>